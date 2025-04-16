@extends('layouts.layout')

@section('title', 'Registrasi')

@section('content')
    <!-- Konten Registrasi -->
    <div class="status-container">
        <h4>Pilih Status Akademik</h4>
        <p>Silahkan pilih salah satu status akademik untuk semester ini:</p>
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="status-icon bg-success"><i class="bi bi-person-check"></i></div>
                    <div class="ms-3">
                        <h5 class="mb-1">Aktif</h5>
                        <p class="mb-0">Mengikuti perkuliahan pada semester ini dan mengisi Rencana Studi (IRS)</p>
                    </div>
                </div>
                <!-- Tombol Aktif -->
                <button class="btn btn-success" id="statusAktifBtn" data-status="1">Pilih</button>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="status-icon bg-danger"><i class="bi bi-person-x"></i></div>
                    <div class="ms-3">
                        <h5 class="mb-1">Cuti</h5>
                        <p class="mb-0">Menghentikan kuliah sementara tanpa kehilangan status sebagai mahasiswa Undip</p>
                    </div>
                </div>
                <!-- Tombol Cuti -->
                <button class="btn btn-danger" id="statusCutiBtn" data-status="0">Pilih</button>
            </div>
        </div>
    </div>

    <!-- Status Akademik -->
    <div class="academic-status">
        <h4><i class="bi bi-building"></i> Status Akademik</h4>
        <p class="text-muted">Status akademik saat ini: <span id="currentStatus" class="fw-bold">
            @if($mahasiswa->status === 'belum_dipilih')
                Belum dipilih
            @elseif($mahasiswa->status === 'aktif')
                Aktif
            @else
                Cuti
            @endif
        </span></p>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Konfirmasi Perubahan Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin mengubah status akademik Anda menjadi <span id="modalStatus"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmStatusChange">Ya, Ubah Status</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusAktifBtn = document.getElementById('statusAktifBtn');
            const statusCutiBtn = document.getElementById('statusCutiBtn');
            const currentStatus = document.getElementById('currentStatus');
            const nim = '{{ $mahasiswa->nim }}'; // Ambil nim mahasiswa dari Blade
            const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
            const modalStatusText = document.getElementById('modalStatus');
            const confirmStatusChangeBtn = document.getElementById('confirmStatusChange');
            let selectedStatus = null;

            // Mengecek jika status sudah dipilih
            if ('{{ $mahasiswa->status }}' !== 'belum_dipilih' ) {
                disableButtons();
            }

            // Event Listener untuk tombol "Aktif"
            statusAktifBtn.addEventListener('click', function () {
                selectedStatus = 'aktif';
                modalStatusText.textContent = 'Aktif';
                statusModal.show();
            });

            // Event Listener untuk tombol "Cuti"
            statusCutiBtn.addEventListener('click', function () {
                selectedStatus = 0;
                modalStatusText.textContent = 'Cuti';
                statusModal.show();
            });

            // Event Listener untuk tombol konfirmasi perubahan status
            confirmStatusChangeBtn.addEventListener('click', async function () {
                try {
                    const response = await fetch('/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ nim: nim, status: selectedStatus })
                    });

                    const result = await response.json();

                    if (result.status === 'success') {
                        // Update status di halaman
                        currentStatus.textContent = selectedStatus === 'aktif' ? 'Aktif' : 'Cuti';
                        statusModal.hide(); // Menutup modal setelah berhasil
                        disableButtons();  // Sembunyikan tombol setelah berhasil
                    } else {
                        alert('Gagal memperbarui status.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                }
            });

            // Fungsi untuk menyembunyikan tombol setelah status dipilih
            function disableButtons() {
                statusAktifBtn.style.display = 'none';
                statusCutiBtn.style.display = 'none';
            }
        });
    </script>
@endsection
