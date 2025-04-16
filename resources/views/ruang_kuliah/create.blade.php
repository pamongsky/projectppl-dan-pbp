@extends('layouts.layout')


@section('content')
<div class="container">
    <h2>Tambah Ruang Baru</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('ruang-kuliah.store') }}" method="POST">
    @csrf
    <input type="hidden" name="idProdi" value="{{ $idProdi }}">
    <div class="form-group">
        <label for="kodeRuang">Nomer Ruang</label>
        <input type="text" name="kodeRuang" class="form-control" value="{{ old('kodeRuang') }}" required>
    </div>
    <div class="form-group">
        <label for="namaRuang">Nama Ruang</label>
        <input type="text" name="namaRuang" class="form-control" value="{{ old('namaRuang') }}" required>
    </div>
    <div class="form-group">
        <label for="kapasitas">Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Tambah Ruang</button>
    <a href="{{ route('ruang-kuliah.show', $idProdi) }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
@endsection