@extends('layouts.layout')

@section('title', 'Penyusunan Jadwal Kuliah')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-center">Penyusunan Jadwal Kuliah</h2>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah Jadwal -->
    <div class="card p-4 mb-4">
        <h4>Form Penambahan Jadwal Kuliah</h4>
        <form action="{{ route('kaprodi.jadwal_kuliah.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Tahun Ajaran -->
                <div class="col-md-4 form-group">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <select class="form-control" name="tahun_ajaran" id="tahun_ajaran" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($tahunAjarans as $tahunAjaran)
                            <option value="{{ $tahunAjaran->id }}">{{ $tahunAjaran->namaThnAjaran }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Kuliah -->
                <div class="col-md-4 form-group">
                    <div class="d-flex align-items-center">
                        <label for="mata_kuliah" class="mb-0">Mata Kuliah</label>
                        <button type="button" class="btn btn-link p-0 ml-2" id="openAddDosenModal">
                            <img src="{{ asset('images/add_icon.png') }}" alt="Tambah Dosen Pengampu" style="width: 20px; height: 20px;">
                        </button>
                    </div>
                    <select class="form-control" name="mata_kuliah" id="mata_kuliah" required>
                        <option value="">Pilih Mata Kuliah</option>
                        @foreach($mataKuliahs as $mataKuliah)
                            <option value="{{ $mataKuliah->kode_mata_kuliah }}">{{ $mataKuliah->nama_mata_kuliah }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hari -->
                <div class="col-md-4 form-group">
                    <label for="hari">Pilih Hari</label>
                    <select class="form-control" name="hari" id="hari" required>
                        <option value="">Pilih Hari</option>
                        @foreach ($days as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Waktu Mulai -->
                <div class="col-md-4 form-group">
                    <label for="waktu_mulai">Waktu Mulai</label>
                    <input type="time" class="form-control" name="waktu_mulai" id="waktu_mulai" required>
                </div>

                <!-- Kelas -->
                <div class="col-md-4 form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" class="form-control" name="kelas" id="kelas" required>
                </div>

                <!-- Ruangan -->
                <div class="col-md-4 form-group">
                    <label for="ruang_kuliah">Ruangan</label>
                    <select class="form-control" name="ruangan" id="ruangan" required>
                        <option value="">Pilih Ruangan</option>
                        @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->kodeRuang }}">{{ $ruangan->namaRuang }}</option> <!-- Pastikan menggunakan nama kolom yang benar -->
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Kuota -->
                <div class="col-md-4 form-group">
                    <label for="kuota">Kuota</label>
                    <input type="number" class="form-control" name="kuota" id="kuota" required>
                </div>  


                <!-- Submit Button -->
                <div class="col-md-4 form-group d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Simpan Jadwal</button>
                </div>
            </div>
        </form>
        <!-- Label "Lihat Jadwal" -->
        <a href="{{ route('kaprodi.jadwal_list') }}" class="btn btn-secondary position-absolute" style="bottom: 10px; right: 10px;">
            Lihat Jadwal
        </a>
    </div>


    

    <!-- Menyertakan modal -->
    <div class="modal fade" id="addDosenModal" tabindex="-1" role="dialog" aria-labelledby="addDosenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDosenModalLabel">Tambah Dosen Pengampu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{ route('kaprodi.simpan_dosen_pengampu') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="mata_kuliah">Mata Kuliah</label>
                        <select name="mata_kuliah" id="mata_kuliah" class="form-control" required>
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliahs as $mataKuliah)
                                <option value="{{ $mataKuliah->kode_mata_kuliah }}">{{ $mataKuliah->nama_mata_kuliah }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nip_dosen">Nama Dosen</label>
                        <select name="nip_dosen" id="nip_dosen" class="form-control" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->nip }}">{{ $dosen->namaDosen }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>


                </div>
            </div>
        </div>
    </div>



     
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Mengambil tombol dan modal
                        const openModalButton = document.getElementById("openAddDosenModal");
                        const modal = document.getElementById("addDosenModal");
                        const closeButton = modal.querySelector(".close");

                        // Fungsi untuk membuka modal
                        openModalButton.addEventListener("click", function() {
                            modal.classList.add("show");
                            modal.style.display = "block";
                            document.body.style.overflow = "hidden"; // Menonaktifkan scroll saat modal terbuka
                        });

                        // Fungsi untuk menutup modal
                        closeButton.addEventListener("click", function() {
                            modal.classList.remove("show");
                            modal.style.display = "none";
                            document.body.style.overflow = ""; // Mengaktifkan kembali scroll saat modal ditutup
                        });

                        // Menutup modal jika klik di luar modal
                        window.addEventListener("click", function(event) {
                            if (event.target === modal) {
                                closeButton.click();
                            }
                        });
                    });
                </script>
            </tbody>
        </table>
    </div>
</div>
@endsection