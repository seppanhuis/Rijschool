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

        $validated['is_actief'] = $request->boolean('is_actief');
        $validated['opmerking'] = $validated['opmerking'] ?? null;

        try {
            $newId = $this->leerlingModel->sp_CreateLeerling($validated);

            return redirect()
                ->route('leerlingen.index')
                ->with('success', 'Leerling succesvol toegevoegd met id ' . $newId . '.');
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

        $validated['is_actief'] = $request->boolean('is_actief');
        $validated['opmerking'] = $validated['opmerking'] ?? null;

        try {
            $affected = $this->leerlingModel->sp_UpdateLeerling($id, $validated);

            if ($affected > 0) {
                return redirect()
                    ->route('leerlingen.index')
                    ->with('success', 'Leerling succesvol gewijzigd.');
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
            $affected = $this->leerlingModel->sp_DeleteLeerling($id);

            if ($affected > 0) {
                return redirect()
                    ->route('leerlingen.index')
                    ->with('success', 'Leerling succesvol verwijderd.');
            }

            return redirect()
                ->route('leerlingen.index')
                ->with('error', 'Leerling is niet verwijderd.');
        } catch (Throwable $throwable) {
            Log::error('Leerling kon niet worden verwijderd.', [
                'id' => $id,
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('leerlingen.index')
                ->with('error', 'Leerling kon niet worden verwijderd.');
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
            'geboortedatum' => ['required', 'date'],
            'telefoon' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150', $uniqueEmail],
            'adres' => ['required', 'string', 'max:150'],
            'postcode' => ['required', 'string', 'max:10'],
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
            'email' => 'Het veld :attribute moet een geldig e-mailadres zijn.',
            'integer' => 'Het veld :attribute moet een geheel getal zijn.',
            'min' => 'Het veld :attribute moet minimaal :min zijn.',
            'boolean' => 'Het veld :attribute moet waar of onwaar zijn.',
            'unique' => 'Er bestaat al een leerling met dit e-mailadres.',
            'exists' => 'De gekozen :attribute bestaat niet.',
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
}
