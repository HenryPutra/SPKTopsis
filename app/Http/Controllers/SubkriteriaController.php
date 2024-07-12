<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubkriteriaController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();
        $subkriteria = Subkriteria::all();

        return view('layouts.subkriteria.index', compact('alternatif', 'kriteria', 'subkriteria'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $alternatifId = $request->input('alternatif_id');

        DB::beginTransaction();
        try {
            foreach ($data as $key => $value) {
                if ($key != 'alternatif_id') {
                    Subkriteria::updateOrCreate(
                        ['alternatif_id' => $alternatifId, 'kriteria_id' => $key],
                        ['nilai' => $value]
                    );
                }
            }
            DB::commit();
            return redirect()->route('subkriteria.index')->with('toast_success', 'Subkriteria diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('subkriteria.index')->with('toast_error', 'Terjadi kesalahan saat memperbarui subkriteria.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method', 'alternatif_id']);
        $alternatifId = $request->input('alternatif_id');

        DB::beginTransaction();
        try {
            foreach ($data as $key => $value) {
                if ($key != 'alternatif_id') {
                    Subkriteria::where('alternatif_id', $alternatifId)
                        ->where('kriteria_id', $key)
                        ->update(['nilai' => $value]);
                }
            }
            DB::commit();
            return redirect()->route('subkriteria.index')->with('toast_success', 'Subkriteria diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('subkriteria.index')->with('toast_error', 'Terjadi kesalahan saat memperbarui subkriteria.');
        }
    }
}
