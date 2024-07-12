<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::all();
        return view('layouts.alternatif.index', compact('alternatif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:alternatif',
            'alternatif' => 'required',
        ]);

        Alternatif::create($request->all());

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif created successfully.');
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'kode' => 'required|unique:alternatif,kode,' . $alternatif->id,
            'alternatif' => 'required',
        ]);

        $alternatif->update($request->all());

        return redirect()->back()->with('success', 'Alternatif updated successfully.');
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();

        return redirect()->back()->with('success', 'Alternatif deleted successfully.');
    }
}
