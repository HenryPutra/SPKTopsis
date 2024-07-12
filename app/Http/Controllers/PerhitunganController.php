<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {
        // Ambil data kriteria dan alternatif dari database
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::with('subkriteria')->get()->keyBy('id'); // Ensure data is keyed by 'id'

        // Lakukan perhitungan TOPSIS
        $matrixNormalisasi = $this->hitungMatrixNormalisasi($alternatif, $kriteria);
        $matrixNormalisasiTerbobot = $this->hitungMatrixNormalisasiTerbobot($matrixNormalisasi, $kriteria);
        $idealPositifNegatif = $this->hitungIdealPositifNegatif($matrixNormalisasiTerbobot, $kriteria);
        $jarakIdeal = $this->hitungJarakIdeal($matrixNormalisasiTerbobot, $idealPositifNegatif);
        $nilaiPreferensi = $this->hitungNilaiPreferensi($jarakIdeal);

        // Kirim data ke view
        return view('layouts.perhitungan.index', compact('kriteria', 'alternatif', 'matrixNormalisasi', 'matrixNormalisasiTerbobot', 'idealPositifNegatif', 'jarakIdeal', 'nilaiPreferensi'));
    }

    private function hitungMatrixNormalisasi($alternatif, $kriteria)
    {
        $matrixNormalisasi = [];

        // Hitung sumSquare untuk setiap kriteria
        $sumSquare = [];
        foreach ($kriteria as $kriteriaItem) {
            $sumSquare[$kriteriaItem->id] = 0;
            foreach ($alternatif as $alt) {
                $subkriteria = $alt->subkriteria->where('kriteria_id', $kriteriaItem->id)->first();
                if ($subkriteria) {
                    $nilai = $subkriteria->nilai;
                    $sumSquare[$kriteriaItem->id] += pow($nilai, 2);
                }
            }
        }

        // Hitung matrix normalisasi
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $kriteriaItem) {
                $subkriteria = $alt->subkriteria->where('kriteria_id', $kriteriaItem->id)->first();
                if ($subkriteria) {
                    $nilai = $subkriteria->nilai;
                    $matrixNormalisasi[$alt->id][$kriteriaItem->id] = $nilai / sqrt($sumSquare[$kriteriaItem->id]);
                } else {
                    $matrixNormalisasi[$alt->id][$kriteriaItem->id] = 0;
                }
            }
        }

        return $matrixNormalisasi;
    }

    private function hitungMatrixNormalisasiTerbobot($matrixNormalisasi, $kriteria)
    {
        $matrixNormalisasiTerbobot = [];

        foreach ($matrixNormalisasi as $altId => $nilai) {
            foreach ($kriteria as $kriteriaItem) {
                $matrixNormalisasiTerbobot[$altId][$kriteriaItem->id] = $nilai[$kriteriaItem->id] * $kriteriaItem->bobot;
            }
        }

        return $matrixNormalisasiTerbobot;
    }

    private function hitungIdealPositifNegatif($matrixNormalisasiTerbobot, $kriteria)
    {
        $idealPositif = [];
        $idealNegatif = [];

        foreach ($kriteria as $kriteriaItem) {
            $nilaiKriteria = array_column($matrixNormalisasiTerbobot, $kriteriaItem->id);
            if ($kriteriaItem->flag == 'benefit') {
                $idealPositif[$kriteriaItem->id] = max($nilaiKriteria);
                $idealNegatif[$kriteriaItem->id] = min($nilaiKriteria);
            } else {
                $idealPositif[$kriteriaItem->id] = min($nilaiKriteria);
                $idealNegatif[$kriteriaItem->id] = max($nilaiKriteria);
            }
        }

        return ['positif' => $idealNegatif, 'negatif' => $idealPositif];
    }

    private function hitungJarakIdeal($matrixNormalisasiTerbobot, $idealPositifNegatif)
    {
        $jarakIdeal = [];

        foreach ($matrixNormalisasiTerbobot as $altId => $nilai) {
            $jarakPositif = 0;
            $jarakNegatif = 0;

            foreach ($nilai as $kriteriaId => $val) {
                $jarakPositif += pow($val - $idealPositifNegatif['positif'][$kriteriaId], 2);
                $jarakNegatif += pow($val - $idealPositifNegatif['negatif'][$kriteriaId], 2);
            }

            $jarakIdeal[$altId]['positif'] = sqrt($jarakPositif);
            $jarakIdeal[$altId]['negatif'] = sqrt($jarakNegatif);
        }

        return $jarakIdeal;
    }

    private function hitungNilaiPreferensi($jarakIdeal)
    {
        $nilaiPreferensi = [];

        foreach ($jarakIdeal as $altId => $nilai) {
            $nilaiPreferensi[$altId] = $nilai['negatif'] / ($nilai['positif'] + $nilai['negatif']);
        }

        arsort($nilaiPreferensi);

        return $nilaiPreferensi;
    }
}
