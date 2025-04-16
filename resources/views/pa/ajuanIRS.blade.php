@extends('layouts.layout')

@section('title', 'Ajuan IRS')

@section('content')
<div class="container">
    <h2 class="mb-4">Rekap Ajuan IRS Mahasiswa</h2>

    <!-- Pencarian -->
    <form action="{{ route('pa.ajuanIRS') }}" method="get" class="mb-4">
        <input type="text" class="form-control w-100" placeholder="Search mahasiswa" name="search" value="{{ request('search') }}">
    </form>

    <!-- Tabel Rekap IRS -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapIrs as $rekap)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rekap->mahasiswa->namaMahasiswa }}</td>
                    <td>{{ $rekap->mahasiswa->nim }}</td>
                    <td>
                        @if ($rekap->status == 'pending')
                            <span class="text-warning">Ajuan IRS</span>
                        @elseif ($rekap->status == 'disetujui')
                            <span class="text-success">Sudah Disetujui</span>
                        @else
                            <span class="text-danger">Tidak Disetujui</span>
                        @endif
                    </td>

                    <td>
                        <!-- Tombol Aksi Tanpa Aksi -->
                        <button class="btn btn-success btn-sm" disabled>Setujui</button>
                        <button class="btn btn-danger btn-sm" disabled>Tolak</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {!! $rekapIrs->links('pagination::bootstrap-4') !!}
    </div>

</div>
@endsection
