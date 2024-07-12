@extends('layouts.app')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">{{ __('Kriteria') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
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
        <h6 class="m-0 font-weight-bold text-primary">Kriteria</h6>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#createModal">Tambah
            Kriteria</button>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Kriteria</th>
                    <th>Nama Kriteria</th>
                    <th>Tipe Kriteria</th>
                    <th>Bobot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $kriteria)
                <tr>
                    <td>{{ $kriteria->kode_kriteria }}</td>
                    <td>{{ $kriteria->nama_kriteria }}</td>
                    <td>{{ $kriteria->tipe_kriteria }}</td>
                    <td>{{ $kriteria->bobot }}</td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal"
                            data-target="#editModal{{ $kriteria->id }}">Edit</button>
                        <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $kriteria->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Kriteria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Kode Kriteria</label>
                                        <input type="text" name="kode_kriteria" class="form-control"
                                            value="{{ $kriteria->kode_kriteria }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kriteria</label>
                                        <input type="text" name="nama_kriteria" class="form-control"
                                            value="{{ $kriteria->nama_kriteria }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipe Kriteria</label>
                                        <select name="tipe_kriteria" class="form-control" required>
                                            <option value="benefit"
                                                {{ $kriteria->tipe_kriteria == 'benefit' ? 'selected' : '' }}>Benefit
                                            </option>
                                            <option value="cost"
                                                {{ $kriteria->tipe_kriteria == 'cost' ? 'selected' : '' }}>Cost</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bobot</label>
                                        <input type="number" step="0.001" name="bobot" class="form-control"
                                            value="{{ $kriteria->bobot }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kriteria.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kode Kriteria</label>
                        <input type="text" name="kode_kriteria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Kriteria</label>
                        <select name="tipe_kriteria" class="form-control" required>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" step="0.001" name="bobot" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection