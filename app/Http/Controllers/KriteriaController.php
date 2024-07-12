<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('layouts.kriteria.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriteria',
            'nama_kriteria' => 'required',
            'tipe_kriteria' => 'required',
            'bobot' => 'required|numeric',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria created successfully.');
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriteria,kode,' . $kriteria->id,
            'nama_kriteria' => 'required',
            'tipe_kriteria' => 'required',
            'bobot' => 'required|numeric',
        ]);

        $kriteria->update($request->all());

        return redirect()->back()->with('success', 'Kriteria updated successfully.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();

        return redirect()->back()->with('success', 'Kriteria deleted successfully.');
    }
}
