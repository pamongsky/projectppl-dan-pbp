import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Menangani event klik tombol Detail untuk memasukkan data ke modal
$('#mahasiswaDetailModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Tombol yang dipencet
    var nama = button.data('nama');
    var nim = button.data('nim');
    var angkatan = button.data('angktan');
    var status = button.data('status');
    
    var statusText = status === true ? 'Disetujui' : (status === false ? 'Tidak Disetujui' : 'Belum Disetujui');
    
    var modal = $(this);
    modal.find('#nama-mahasiswa').text(nama);
    modal.find('#nim-mahasiswa').text(nim);
    modal.find('#angkatan-mahasiswa').text(angkatan);
    modal.find('#status-mahasiswa').text(statusText);
});


