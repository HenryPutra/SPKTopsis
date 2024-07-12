@extends('layouts.app')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">{{ __('Subkriteria') }}</h1>

@if (session('toast_success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('toast_success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Subkriteria</h6>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#createSubkriteriaModal">Tambah
            Subkriteria</button>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($kriteria as $kriteriaItem)
                    <th>{{ $kriteriaItem->nama_kriteria }}</th>
                    @endforeach
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alternatif as $alternatifItem)
                <tr>
                    <td>{{ $alternatifItem->nama }}</td>
                    @foreach($kriteria as $kriteriaItem)
                    <td>{{ optional($subkriteria->where('alternatif_id', $alternatifItem->id)->where('kriteria_id', $kriteriaItem->id)->first())->nilai }}
                    </td>
                    @endforeach
                    <td>
                        <button class="btn btn-warning" data-toggle="modal"
                            data-target="#editSubkriteriaModal{{ $alternatifItem->id }}">Edit</button>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editSubkriteriaModal{{ $alternatifItem->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editSubkriteriaModalLabel{{ $alternatifItem->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSubkriteriaModalLabel{{ $alternatifItem->id }}">Edit
                                    Subkriteria
                                    {{ $alternatifItem->nama }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('subkriteria.update', $alternatifItem->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="alternatif_id" value="{{ $alternatifItem->id }}">
                                    @foreach($kriteria as $kriteriaItem)
                                    <div class="form-group">
                                        <label
                                            for="kriteria_{{ $kriteriaItem->id }}">{{ $kriteriaItem->nama_kriteria }}</label>
                                        <input type="number" class="form-control" id="kriteria_{{ $kriteriaItem->id }}"
                                            name="{{ $kriteriaItem->id }}"
                                            value="{{ optional($subkriteria->where('alternatif_id', $alternatifItem->id)->where('kriteria_id', $kriteriaItem->id)->first())->nilai }}"
                                            required>
                                    </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createSubkriteriaModal" tabindex="-1" role="dialog"
    aria-labelledby="createSubkriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubkriteriaModalLabel">Tambah Subkriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subkriteria.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="alternatif_id">Alternatif</label>
                        <select class="form-control" id="alternatif_id" name="alternatif_id" required>
                            @foreach($alternatif as $alternatifItem)
                            <option value="{{ $alternatifItem->id }}">{{ $alternatifItem->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach($kriteria as $kriteriaItem)
                    <div class="form-group">
                        <label for="kriteria_{{ $kriteriaItem->id }}">{{ $kriteriaItem->nama_kriteria }}</label>
                        <input type="number" class="form-control" id="kriteria_{{ $kriteriaItem->id }}"
                            name="{{ $kriteriaItem->id }}" required>
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection