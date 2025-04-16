@extends('layouts.layout')

@section('title', 'Perwalian')

@section('content')
<div class="container">
    <h2 class="mb-4">Rekap IRS Mahasiswa Perwalian</h2>

    <!-- Filter dan Pencarian -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <!-- Filter berdasarkan status -->
            <a href="{{ route('pa.perwalian', ['status' => 'all']) }}" class="btn btn-outline-secondary {{ $statusFilter == 'all' ? 'active' : '' }}">
                All <span class="badge bg-primary">{{ $allCount }}</span>
            </a>
            <a href="{{ route('pa.perwalian', ['status' => 'disetujui']) }}" class="btn btn-outline-secondary {{ $statusFilter == 'disetujui' ? 'active' : '' }}">
                Disetujui <span class="badge bg-success">{{ $disetujuiCount }}</span>
            </a>
            <a href="{{ route('pa.perwalian', ['status' => 'belum']) }}" class="btn btn-outline-secondary {{ $statusFilter == 'belum' ? 'active' : '' }}">
                Belum Disetujui <span class="badge bg-secondary">{{ $belumDisetujuiCount }}</span>
            </a>
            <a href="{{ route('pa.perwalian', ['status' => 'tidak']) }}" class="btn btn-outline-secondary {{ $statusFilter == 'tidak' ? 'active' : '' }}">
                Tidak Disetujui <span class="badge bg-danger">{{ $tidakDisetujuiCount }}</span>
            </a>
        </div>
        <form action="{{ route('pa.perwalian') }}" method="get">
            <input type="text" class="form-control w-100" placeholder="Search mahasiswa" name="search" value="{{ request('search') }}">
        </form>
    </div>

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
                        @if ($rekap->status == 'belum disetujui')
                            <span class="text-danger">Tidak Disetujui</span>
                        @elseif ($rekap->status == 'disetujui')
                            <span class="text-success">Sudah Disetujui</span>
                        @else
                            <span class="text-warning">Belum Disetujui</span>
                        @endif
                    </td>

                    <td>
                        <!-- Tombol Detail -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rekapDetailModal{{ $rekap->id }}"
                            data-nama="{{ $rekap->mahasiswa->namaMahasiswa }}" data-nim="{{ $rekap->mahasiswa->nim }}" 
                            data-status="{{ $rekap->status }}">
                            Detail
                        </button>
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

<!-- Modal untuk Detail Mahasiswa -->
@foreach ($rekapIrs as $rekap)
<div class="modal fade" id="rekapDetailModal{{ $rekap->id }}" tabindex="-1" aria-labelledby="rekapDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekapDetailModalLabel">Detail Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Mahasiswa: {{ $rekap->mahasiswa->namaMahasiswa }}</strong> <span id="nama-mahasiswa"></span></p>
                <p><strong>NIM:{{ $rekap->mahasiswa->nim }}</strong> <span id="nim-mahasiswa"></span></p>
                <p><strong>Status:{{ $rekap->mahasiswa->status }}</strong> <span id="status-mahasiswa"></span></p>
                <p><strong>Nama Pembimbing Akademik:{{ $rekap->mahasiswa->NIPWali }}</strong> <span id="nama-pa"></span></p>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    var modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
    modalTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', function() {
            var nama = this.getAttribute('data-nama');
            var nim = this.getAttribute('data-nim');
            var status = this.getAttribute('data-status');
            var namaPa = this.getAttribute('data-nama-pa');
            
            var modal = document.getElementById(this.getAttribute('data-bs-target').substring(1));
            modal.querySelector('#nama-mahasiswa').textContent = nama;
            modal.querySelector('#nim-mahasiswa').textContent = nim;
            modal.querySelector('#status-mahasiswa').textContent = status == 1 ? 'Disetujui' : (status == 0 ? 'Tidak Disetujui' : 'Belum Disetujui');
            modal.querySelector('#nama-pa').textContent = namaPa;
        });
    });
</script>
@endpush
