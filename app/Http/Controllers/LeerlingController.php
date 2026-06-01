<?php

namespace App\Http\Controllers;

use App\Models\Leerling;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class LeerlingController extends Controller
{
    private Leerling $leerlingModel;

    public function __construct()
    {
        $this->leerlingModel = new Leerling();
    }

    public function index(): View|RedirectResponse
    {
        try {
            return view('leerlingen.index', [
                'title' => 'Leerlingen',
                'leerlingen' => $this->leerlingModel->sp_GetAllLeerlingen(),
            ]);
        } catch (Throwable $throwable) {
            Log::error('Leerlingen overzicht kon niet worden geladen.', [
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('dashboard')
                ->with('error', 'Het leerlingenoverzicht kon niet worden geladen.');
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            return view('leerlingen.create', [
                'title' => 'Nieuwe leerling toevoegen',
                'instructeurs' => $this->leerlingModel->sp_GetActieveInstructeurs(),
                'lespakketten' => $this->leerlingModel->sp_GetActieveLespakketten(),
                'minGeboortedatum' => now()->subYears(115)->toDateString(),
                'maxGeboortedatum' => now()->toDateString(),
            ]);
        } catch (Throwable $throwable) {
            Log::error('Leerling create-formulier kon niet worden geladen.', [
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('leerlingen.index')
                ->with('error', 'Het formulier voor een nieuwe leerling kon niet worden geladen.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages(), $this->validationAttributes());
        $leerlingNaam = trim($validated['voornaam'] . ' ' . $validated['achternaam']);

        $validated['is_actief'] = $request->boolean('is_actief');
        $validated['opmerking'] = $validated['opmerking'] ?? null;

        try {
            $newId = $this->leerlingModel->sp_CreateLeerling($validated);

            return redirect()
                ->route('leerlingen.index')
                ->with('success', 'Leerling ' . $leerlingNaam . ' succesvol toegevoegd.');
        } catch (Throwable $throwable) {
            Log::error('Leerling kon niet worden aangemaakt.', [
                'error' => $throwable->getMessage(),
                'data' => $validated,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Leerling kon niet worden opgeslagen.');
        }
    }

    public function show(int $id): View|RedirectResponse
    {
        try {
            $leerling = $this->leerlingModel->sp_GetLeerlingById($id);

            if (! $leerling) {
                abort(404);
            }

            return view('leerlingen.show', [
                'title' => 'Leerling detail',
                'leerling' => $leerling,
            ]);
        } catch (Throwable $throwable) {
            Log::error('Leerling detail kon niet worden geladen.', [
                'id' => $id,
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('leerlingen.index')
                ->with('error', 'Het detail van de leerling kon niet worden geladen.');
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $leerling = $this->leerlingModel->sp_GetLeerlingById($id);

            if (! $leerling) {
                abort(404);
            }

            return view('leerlingen.edit', [
                'title' => 'Leerling wijzigen',
                'leerling' => $leerling,
                'instructeurs' => $this->leerlingModel->sp_GetActieveInstructeurs(),
                'lespakketten' => $this->leerlingModel->sp_GetActieveLespakketten(),
                'minGeboortedatum' => now()->subYears(115)->toDateString(),
                'maxGeboortedatum' => now()->toDateString(),
            ]);
        } catch (Throwable $throwable) {
            Log::error('Leerling bewerkformulier kon niet worden geladen.', [
                'id' => $id,
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('leerlingen.index')
                ->with('error', 'Het bewerkscherm van de leerling kon niet worden geladen.');
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate($this->validationRules($id), $this->validationMessages(), $this->validationAttributes());
        $leerling = $this->leerlingModel->sp_GetLeerlingById($id);
        $leerlingNaam = $leerling?->Voornaam && $leerling?->Achternaam
            ? trim($leerling->Voornaam . ' ' . $leerling->Achternaam)
            : 'Leerling';

        $validated['is_actief'] = $request->boolean('is_actief');
        $validated['opmerking'] = $validated['opmerking'] ?? null;

        try {
            $affected = $this->leerlingModel->sp_UpdateLeerling($id, $validated);

            if ($affected > 0) {
                return redirect()
                    ->route('leerlingen.index')
                    ->with('success', 'Leerling ' . $leerlingNaam . ' succesvol gewijzigd.');
            }

            return back()
                ->withInput()
                ->with('error', 'Leerling is niet gewijzigd.');
        } catch (Throwable $throwable) {
            Log::error('Leerling kon niet worden bijgewerkt.', [
                'id' => $id,
                'error' => $throwable->getMessage(),
                'data' => $validated,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Leerling kon niet worden bijgewerkt.');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $leerling = $this->leerlingModel->sp_GetLeerlingById($id);
            $leerlingNaam = $leerling?->Voornaam && $leerling?->Achternaam
                ? trim($leerling->Voornaam . ' ' . $leerling->Achternaam)
                : 'Leerling';

            $affected = $this->leerlingModel->sp_DeleteLeerling($id);

            if ($affected > 0) {
                return redirect()
                    ->route('leerlingen.index')
                    ->with('success', 'Leerling ' . $leerlingNaam . ' succesvol verwijderd.');
            }

            return redirect()
                ->route('leerlingen.index')
                ->with('delete_error', 'Leerling ' . $leerlingNaam . ' kon niet worden verwijderd. Mogelijk is deze leerling nog gekoppeld aan lessen of andere gegevens.');
        } catch (Throwable $throwable) {
            Log::error('Leerling kon niet worden verwijderd.', [
                'id' => $id,
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('leerlingen.index')
                ->with('delete_error', $this->deleteFailureReason($throwable));
        }
    }

    private function validationRules(?int $id = null): array
    {
        $uniqueEmail = Rule::unique('Leerlingen', 'Email');

        if ($id !== null) {
            $uniqueEmail = $uniqueEmail->ignore($id, 'LeerlingId');
        }

        return [
            'voornaam' => ['required', 'string', 'max:100'],
            'achternaam' => ['required', 'string', 'max:100'],
            'geboortedatum' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:' . now()->subYears(115)->toDateString()],
            'telefoon' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150', $uniqueEmail],
            'adres' => ['required', 'string', 'max:150', 'regex:/^(?=.*[A-Za-zÀ-ÿ])(?=.*\d)[A-Za-zÀ-ÿ0-9\s\-\',.\/]+$/u'],
            'postcode' => ['required', 'string', 'max:10', 'regex:/^\d{4}\s?[A-Z]{2}$/i'],
            'woonplaats' => ['required', 'string', 'max:100'],
            'instructeur_id' => ['required', 'integer', Rule::exists('Instructeurs', 'InstructeurId')],
            'lespakket_id' => ['required', 'integer', Rule::exists('Lespakketten', 'LespakketId')],
            'les_tegoed' => ['required', 'integer', 'min:0', 'max:999'],
            'is_actief' => ['nullable', 'boolean'],
            'opmerking' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function validationMessages(): array
    {
        return [
            'required' => 'Het veld :attribute is verplicht.',
            'string' => 'Het veld :attribute moet uit tekst bestaan.',
            'max' => 'Het veld :attribute mag maximaal :max tekens bevatten.',
            'date' => 'Het veld :attribute moet een geldige datum zijn.',
            'before_or_equal' => 'Het veld :attribute mag niet in de toekomst liggen.',
            'after_or_equal' => 'Het veld :attribute mag niet ouder zijn dan 115 jaar.',
            'email' => 'Het veld :attribute moet een geldig e-mailadres zijn.',
            'integer' => 'Het veld :attribute moet een geheel getal zijn.',
            'min' => 'Het veld :attribute moet minimaal :min zijn.',
            'boolean' => 'Het veld :attribute moet waar of onwaar zijn.',
            'unique' => 'Er bestaat al een leerling met dit e-mailadres.',
            'exists' => 'De gekozen :attribute bestaat niet.',
            'regex' => 'Het veld :attribute heeft geen geldig formaat.',
        ];
    }

    private function validationAttributes(): array
    {
        return [
            'voornaam' => 'voornaam',
            'achternaam' => 'achternaam',
            'geboortedatum' => 'geboortedatum',
            'telefoon' => 'telefoon',
            'email' => 'e-mailadres',
            'adres' => 'adres',
            'postcode' => 'postcode',
            'woonplaats' => 'woonplaats',
            'instructeur_id' => 'instructeur',
            'lespakket_id' => 'lespakket',
            'les_tegoed' => 'les tegoed',
            'is_actief' => 'actief',
            'opmerking' => 'opmerking',
        ];
    }

    private function deleteFailureReason(Throwable $throwable): string
    {
        $message = mb_strtolower($throwable->getMessage());

        if (str_contains($message, 'foreign key') || str_contains($message, 'integrity constraint')) {
            return 'Leerling kon niet worden verwijderd omdat er nog gegevens aan deze leerling gekoppeld zijn.';
        }

        if (str_contains($message, 'not found') || str_contains($message, 'unknown')) {
            return 'Leerling kon niet worden verwijderd omdat deze niet meer bestaat.';
        }

        return 'Leerling kon niet worden verwijderd door een technische fout.';
    }
}
