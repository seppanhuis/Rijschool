<?php

namespace App\Http\Controllers;

use App\Models\Facaturen;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class FacaturenController extends Controller
{
    private Facaturen $facaturenModel;

    public function __construct()
    {
        $this->facaturenModel = new Facaturen();
    }

    /**
     * Overzicht van alle lespakketten
     */
   public function index()
{
    return view('facaturen.index', [
        'title' => 'Lespakketten',
        'lespakketten' => $this->facaturenModel->sp_GetAllLespakketten(),
    ]);
}

    /**
     * Toon betaalpagina
     */
    public function create(int $id): View|RedirectResponse
    {
        try {

            $lespakket = $this->facaturenModel->sp_GetLespakkettenById($id);

            if (!$lespakket) {
                abort(404);
            }

            return view('facaturen.create', [
                'title' => 'Betalen',
                'lespakket' => $lespakket,
            ]);

        } catch (Throwable $throwable) {

            Log::error('Betaalpagina kon niet worden geladen.', [
                'id' => $id,
                'error' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('facaturen.index')
                ->with('error', 'De betaalpagina kon niet worden geladen.');
        }
    }

    /**
     * Verwerk betaling
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kaarthouder' => ['required', 'string', 'max:100'],
            'kaartnummer' => ['required', 'string', 'max:18'],
            'vervaldatum' => ['required', 'string'],
            'cvv' => ['required', 'digits_between:3,4'],
        ]);

        return redirect()
            ->route('facaturen.index')
            ->with('success', 'Betaling succesvol verwerkt.');
    }
}
