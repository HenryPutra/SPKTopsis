@extends('layouts.app')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Perhitungan TOPSIS') }}</h1>

<!-- Matriks Normalisasi -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h5>Matriks Normalisasi</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriteria as $kriteriaItem)
                        <th>{{ $kriteriaItem->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matrixNormalisasi as $altId => $nilai)
                    <tr>
                        <td>{{ $alternatif[$altId]->alternatif }}</td>
                        @foreach ($kriteria as $kriteriaItem)
                        <td>{{ number_format($nilai[$kriteriaItem->id], 4) }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Matriks Normalisasi Terbobot -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h5>Matriks Normalisasi Terbobot</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriteria as $kriteriaItem)
                        <th>{{ $kriteriaItem->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matrixNormalisasiTerbobot as $altId => $nilai)
                    <tr>
                        <td>{{ $alternatif[$altId]->alternatif }}</td>
                        @foreach ($kriteria as $kriteriaItem)
                        <td>{{ number_format($nilai[$kriteriaItem->id], 4) }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Ideal Positif dan Negatif -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h5>Solusi Ideal Positif dan Negatif</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        @foreach ($kriteria as $kriteriaItem)
                        <th>{{ $kriteriaItem->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Positif</td>
                        @foreach ($idealPositifNegatif['positif'] as $nilai)
                        <td>{{ number_format($nilai, 4) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Negatif</td>
                        @foreach ($idealPositifNegatif['negatif'] as $nilai)
                        <td>{{ number_format($nilai, 4) }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Jarak ke Solusi Ideal -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h5>Jarak ke Solusi Ideal</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        <th>Jarak Positif (D+)</th>
                        <th>Jarak Negatif (D-)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jarakIdeal as $altId => $nilai)
                    <tr>
                        <td>{{ $alternatif[$altId]->alternatif }}</td>
                        <td>{{ number_format($nilai['positif'], 4) }}</td>
                        <td>{{ number_format($nilai['negatif'], 4) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Nilai Preferensi dan Perankingan -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h5>Nilai Preferensi dan Perankingan</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Alternatif</th>
                        <th>Nilai Preferensi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 1; @endphp
                    @foreach ($nilaiPreferensi as $altId => $nilai)
                    <tr>
                        <td>{{ $rank++ }}</td>
                        <td>{{ $alternatif[$altId]->alternatif }}</td>
                        <td>{{ number_format($nilai, 4) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection