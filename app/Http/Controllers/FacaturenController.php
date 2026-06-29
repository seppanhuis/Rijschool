<?php

namespace App\Http\Controllers;

use App\Models\Facaturen;
use Illuminate\Http\Request;

class FacaturenController extends Controller
{
    private Facaturen $model;

    public function __construct()
    {
        $this->model = new Facaturen();
    }

    public function index()
    {
        return view('facaturen.index', [
            'title' => 'Facturen',
            'facaturen' => $this->model->getAll()
        ]);
    }

    public function create()
    {
        return view('facaturen.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lespakket_id' => 'required|integer',
            'kaarthouder' => 'required|string|max:100',
            'kaartnummer' => 'required|string|size:18',
            'vervaldatum' => 'required|after_or_equal:today',
            'cvv' => 'required|string|min:3|max:4',
            'opmerking' => 'nullable|string|max:255'
        ]);

        $this->model->createFacatuur($data);

        return redirect()
            ->route('facaturen.index')
            ->with('success','Factuur toegevoegd');
    }

    public function edit($id)
    {
        return view('facaturen.edit', [
            'factuur' => $this->model->getById($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'kaarthouder' => 'required|string|max:100',
            'kaartnummer' => 'required|string|size:18',
            'vervaldatum' => 'required|after_or_equal:today',
            'cvv' => 'required|string|min:3|max:4',
            'isactief' => 'required',
            'opmerking' => 'nullable|string|max:255'
        ]);

        $this->model->updateFacatuur($id, $data);

        return redirect()
            ->route('facaturen.index')
            ->with('success','Factuur aangepast');
    }

    public function destroy($id)
    {
        $this->model->deleteFacatuur($id);

        return redirect()
            ->route('facaturen.index')
            ->with('success','Factuur verwijderd');
    }
}