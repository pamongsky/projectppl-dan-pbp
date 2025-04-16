@extends('layouts.layout')
@extends('layouts.header')

@section('content')
<div class="container">
    <h2>Edit Ruangan</h2>
    <form action="{{ route('ruang-kuliah.update', $ruangan->kodeRuang) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="namaRuang">Nama Ruang</label>
        <input type="text" name="namaRuang" class="form-control" value="{{ $ruangan->namaRuang }}" required>
    </div>
    
    <div class="form-group">
        <label for="kapasitas">Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" value="{{ $ruangan->kapasitas }}" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
