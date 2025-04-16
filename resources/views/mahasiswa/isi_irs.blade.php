
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <style>
        .schedule-slot {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .schedule-slot:hover {
            background-color: #e9ecef;
        }
        .schedule-slot.selected {
            background-color: #28a745;
            
        }
        .progress {
            height: 25px;
        }
        .sks-progress-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: black;
        }
        .irs-badge {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
    </style>


<div class="container mt-4 position-relative">
    <!-- IRS Badge -->
    <span id="irsListBadge" class="badge bg-primary irs-badge" style="display: none;">
        0 Mata Kuliah
    </span>

    <h3>Isi IRS</h3>
    <div class="row mt-3">
        <!-- Panel Kiri -->
        <div class="col-md-4">
            <div class="border p-3 mb-3">
                <h5 class="card-title">{{ $mahasiswa->namaMahasiswa }}</h5>
                <p class="card-text">NIM: {{ $mahasiswa->nim }}</p>
                <p class="card-text">Tahun Ajaran: 2023/2024 Ganjil</p>
                <p class="card-text">Semester: {{ $mahasiswa->semester }}</p>
                <p class="card-text">IPK: {{ $mahasiswa->IPk }}</p>
                <p class="card-text">IPS: 4.00</p>
                
                <!-- SKS Progress Bar -->
                <p class="card-text">SKS Terpilih</p>
                <div class="position-relative">
                    <div class="progress">
                        <div id="sksProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="24">
                            <span id="sksProgressLabel" class="sks-progress-label">0 / 24 SKS</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pencarian Mata Kuliah -->
            <div class="search-box mb-3">
                <input id="searchInput" class="form-control" placeholder="Cari Mata Kuliah..." type="text" />
                <div class="list-group" id="searchResults"></div>
            </div>

            <!-- Course List -->
            <div class="border p-3 mb-3" id="courseListContainer">
                <h5>Daftar Mata Kuliah</h5>
                <ul id="courseList" class="list-group"></ul>
            </div>

            <!-- IRS List -->
            <div class="border p-3 mb-3" id="irsListContainer">
                <h5>Mata Kuliah dalam IRS</h5>
                <ul id="irsList" class="list-group"></ul>
                <button class="btn btn-success mt-3 w-100" id="saveIRS">Simpan IRS</button>
            </div>
        </div>

        <!-- Panel Kanan -->
        <div class="col-md-8">
            <h5>Jadwal Mata Kuliah</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <th>{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach(range(7, 18) as $jam)
                        <tr>
                            <td>{{ str_pad($jam, 2, '0', STR_PAD_LEFT) }}:00</td>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                <td id="slot-{{ $hari }}-{{ $jam }}" class="schedule-slot text-center"></td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

     <!-- Modal IRS List -->
     <div class="modal fade" id="irsListModal" tabindex="-1" aria-labelledby="irsListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="irsListModalLabel">Daftar Mata Kuliah dalam IRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Kode MK</th>
                                <th>Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>SKS</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Ruang</th>
                   
                            </tr>
                        </thead>
                        <tbody id="irsListModalBody">
                            <!-- Akan diisi secara dinamis -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',  async function () {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const courseList = document.getElementById('courseList');
    const irsList = document.getElementById('irsList');
    const sksProgressBar = document.getElementById('sksProgressBar');
    const sksProgressLabel = document.getElementById('sksProgressLabel');
    const saveButton = document.getElementById('saveIRS');

    let totalSKS = 0;
    let courseListData = [];
    let irsListData = [];

    const nim = {{ $mahasiswa->nim }};  // Ambil NIM dari PHP Blade
    const semester = {{ $mahasiswa->semester }};  // Ambil Semester dari PHP Blade

 // Cek apakah sudah ada data IRS (msh error)
    try {
        const response = await fetch(`/get-irs-data?nim=${nim}&semester=${semester}`);
        const result = await response.json();

        // Pastikan result.data adalah array dan memiliki properti 'mataKuliah'
        if (result.status === 'success' && Array.isArray(result.data) && result.data.length > 0) {
            result.data.forEach((item) => {
                // Cek jika mataKuliah ada di dalam item
                if (item.mataKuliah && Array.isArray(item.mataKuliah)) {
                    item.mataKuliah.forEach((mk) => {
                        addCourseToList(mk);
                        // Pastikan mk.jadwal adalah array
                        if (Array.isArray(mk.jadwal)) {
                            mk.jadwal.forEach((jadwal) => {
                                toggleClassSelection(mk, jadwal);
                            });
                        } else {
                            console.warn(`Jadwal untuk mata kuliah ${mk.nama_mata_kuliah} tidak valid:`, mk.jadwal);
                        }
                    });
                }
            });
        } else {
            console.log('Tidak ada data IRS untuk semester ini.');
        }
    } catch (error) {
        console.error('Error fetching IRS data:', error);
    }

    
    // Fungsi untuk menghitung dan memperbarui SKS
    function updateSKSProgress() {
        // Pastikan menggunakan irsListData dan bukan selectedCoursesData
        const calculatedSKS = irsListData.reduce((sum, course) => sum + course.selectedClass.jumlah_sks, 0);
        const percentage = (calculatedSKS / 24) * 100;

        sksProgressBar.style.width = `${Math.min(percentage, 100)}%`;
        sksProgressBar.setAttribute('aria-valuenow', calculatedSKS);
        sksProgressLabel.textContent = `${calculatedSKS} / 24 SKS`;
        
        return calculatedSKS;
    }

    // Bersihkan slot jadwal
    function clearAllScheduleSlots() {
        document.querySelectorAll('.schedule-slot').forEach(slot => {
            slot.innerHTML = '';
            slot.classList.remove('selected');
        });
    }

    // Bersihkan slot jadwal tertentu
    function clearScheduleSlot(hari, jam) {
        const slot = document.getElementById(`slot-${hari}-${jam}`);
        if (slot) {
            slot.innerHTML = '';
            slot.classList.remove('selected');
        }
    }

    // Live search event
    searchInput.addEventListener('input', async () => {
        const query = searchInput.value.trim();
        if (!query) {
            searchResults.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(`/search/mata-kuliah?q=${query}`);
            const mataKuliah = await response.json();
            
            searchResults.innerHTML = '';

            mataKuliah.forEach((mk) => {
                const item = document.createElement('button');
                item.classList.add('list-group-item', 'list-group-item-action');
                item.textContent = `${mk.nama_mata_kuliah} (SKS: ${mk.jumlah_sks}) (Semester: ${mk.semester})`;
                item.onclick = () => addCourseToList(mk);
                searchResults.appendChild(item);
            });
        } catch (error) {
            console.error('Error saat mencari mata kuliah:', error);
        }
    });

    // Tambahkan mata kuliah ke daftar mata kuliah
    function addCourseToList(mk) {
        // Validasi duplicate
        if (courseListData.some(course => course.kode_mata_kuliah === mk.kode_mata_kuliah)) {
            alert('Mata kuliah sudah ada di daftar.');
            return;
        }

        // Tambahkan ke daftar mata kuliah
        courseListData.push(mk);
        
        // Buat item di course list
        const item = document.createElement('li');
        item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        item.innerHTML = `
            ${mk.nama_mata_kuliah} (SKS: ${mk.jumlah_sks})
            <button class="btn btn-sm btn-danger remove-course">Hapus</button>
        `;

        // Tambahkan event listener untuk tombol hapus
    // Tambahkan event listener untuk tombol hapus
    const removeButton = item.querySelector('.remove-course');
    removeButton.addEventListener('click', () => {
        // Hapus dari course list data
        courseListData = courseListData.filter(course => course.kode_mata_kuliah !== mk.kode_mata_kuliah);
        
        // Hapus dari tampilan course list
        courseList.removeChild(item);

        // Hapus jadwal dari tabel jadwal
        if (mk.jadwal && mk.jadwal.length > 0) {
            mk.jadwal.forEach((jadwal) => {
                const waktuParts = jadwal.waktuMulai.split(':');
                const jam = parseInt(waktuParts[0]);
                const hari = jadwal.hari;

                const slot = document.getElementById(`slot-${hari}-${jam}`);
                if (slot) {
                    // Hapus semua elemen jadwal untuk mata kuliah ini dari slot
                    const jadwalElements = slot.querySelectorAll(
                        `.jadwal-kelas[data-kode-mata-kuliah="${mk.kode_mata_kuliah}"]`
                    );
                    jadwalElements.forEach(el => el.remove());
                }
            });
        }
    });

        // Tambahkan ke daftar mata kuliah
        courseList.appendChild(item);
    
        // Tampilkan semua jadwal untuk mata kuliah ini
        if (mk.jadwal && mk.jadwal.length > 0) {
            mk.jadwal.forEach((jadwal) => {
                const waktuParts = jadwal.waktuMulai.split(':');
                const jam = parseInt(waktuParts[0]);
                const hari = jadwal.hari;

                const slot = document.getElementById(`slot-${hari}-${jam}`);
                if (slot) {
                    // Buat elemen jadwal
                    const jadwalElement = document.createElement('div');
                    jadwalElement.classList.add('p-2', 'border', 'rounded', 'bg-light', 'shadow-sm', 'mb-2', 'jadwal-kelas');
                    jadwalElement.dataset.kodeMataKuliah = mk.kode_mata_kuliah;
                    jadwalElement.dataset.kelas = jadwal.kelas;
                
                    jadwalElement.innerHTML = `
                        <small class="d-block">${mk.nama_mata_kuliah}</small>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">(SMT ${mk.semester}) (${mk.jumlah_sks} SKS)</small>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Kelas: ${jadwal.kelas || 'Default'}</small>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">${jadwal.waktuMulai} - ${jadwal.waktuSelesai || ''}</small>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">${jadwal.kuota}/40</small>
                    `;

                    // Tambahkan event listener untuk memilih kelas
                    jadwalElement.addEventListener('click', () => toggleClassSelection(mk, jadwal));

                    // Tambahkan ke slot
                    slot.appendChild(jadwalElement);
                }
            });
        }
    }

    

    // Toggle pemilihan kelas untuk IRS
    function toggleClassSelection(mk, jadwal) {
        // Enhanced kuota validation
        if (!jadwal.kuota) jadwal.kuota = 0;

        const existingElement = document.querySelector(
            `.jadwal-kelas[data-kode-mata-kuliah="${mk.kode_mata_kuliah}"][data-kelas="${jadwal.kelas}"]`
        );
        
        if (!existingElement) return;

        // Strict kuota validation
        if (jadwal.kuota >= 40) {
            alert(`Kelas ${jadwal.kelas} untuk ${mk.nama_mata_kuliah} sudah penuh.`);
            return;
        }

        // Existing course conflict checks
        const existingCourseIndex = irsListData.findIndex(
            course => course.kode_mata_kuliah === mk.kode_mata_kuliah
        );

        if (existingCourseIndex !== -1) {
            alert('Mata kuliah ini sudah dipilih dalam IRS. Hapus terlebih dahulu.');
            return;
        }

        // Time conflict check
        const hasConflict = irsListData.some(course => 
            course.selectedClass.hari === jadwal.hari && 
            isTimeConflict(
                course.selectedClass.waktuMulai, 
                course.selectedClass.waktuSelesai, 
                jadwal.waktuMulai, 
                jadwal.waktuSelesai
            )
        );

        if (hasConflict) {
            alert('Terdapat konflik jadwal dengan mata kuliah lain.');
            return;
        }

        // Update kuota with additional safety checks
        try {
            jadwal.kuota = Math.min(
                (jadwal.kuota || 0) + 1, 
                40
            );
        } catch (error) {
            console.error('Error updating kuota:', error);
            alert('Terjadi kesalahan saat memperbarui kuota.');
            return;
        }

        // Rest of the existing selection logic remains the same...
        const courseForIRS = {
            ...mk,
            selectedClass: {...jadwal, jumlah_sks: mk.jumlah_sks}
        };
        irsListData.push(courseForIRS);

        // Update kuota display
        const kuotaElement = existingElement.querySelector('small:last-child');
        if (kuotaElement) {
            kuotaElement.textContent = `Kuota: ${jadwal.kuota}/40`;
        }

        // Create IRS list item
        const irsItem = document.createElement('li');
        irsItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        irsItem.dataset.kodeMataKuliah = mk.kode_mata_kuliah;
        irsItem.dataset.kelas = jadwal.kelas;
        irsItem.innerHTML = `
            ${mk.nama_mata_kuliah} (Kelas ${jadwal.kelas}) (SKS: ${mk.jumlah_sks})
            <button class="btn btn-sm btn-danger remove-irs-course">Hapus</button>
        `;

        // Remove course from IRS list
        const removeButton = irsItem.querySelector('.remove-irs-course');
        removeButton.addEventListener('click', () => {
            // Safely decrease kuota
            jadwal.kuota = Math.max((jadwal.kuota || 1) - 1, 0);

            // Update kuota display
            const courseElement = document.querySelector(
                `.jadwal-kelas[data-kode-mata-kuliah="${mk.kode_mata_kuliah}"][data-kelas="${jadwal.kelas}"]`
            );
            if (courseElement) {
                const kuotaElement = courseElement.querySelector('small:last-child');
                if (kuotaElement) {
                    kuotaElement.textContent = `Kuota: ${jadwal.kuota}/40`;
                }
            }

            // Remove from IRS list data
            irsListData = irsListData.filter(
                course => !(course.kode_mata_kuliah === mk.kode_mata_kuliah && course.selectedClass.kelas === jadwal.kelas)
            );
            
            // Remove from display
            irsList.removeChild(irsItem);

            // Remove highlight
            const slotElement = document.querySelector(
                `.jadwal-kelas[data-kode-mata-kuliah="${mk.kode_mata_kuliah}"][data-kelas="${jadwal.kelas}"]`
            );
            if (slotElement) {
                slotElement.closest('.schedule-slot').classList.remove('selected');
                slotElement.classList.remove('selected');
            }

            updateIRSBadgeAndModal();
            updateSKSProgress();
        });

        // Add to IRS list
        irsList.appendChild(irsItem);

        // Add highlight
        existingElement.closest('.schedule-slot').classList.add('selected');
        existingElement.classList.add('selected');

        updateIRSBadgeAndModal();

        const calculatedSKS = updateSKSProgress();

        // Check SKS limit
        if (calculatedSKS > 24) {
            alert('Total SKS tidak boleh melebihi max beban sks. Silakan hapus mata kuliah untuk melanjutkan.');
            // Remove from IRS if over SKS limit
            removeButton.click();
        }
        updateSKSProgress();
    }

    // Fungsi untuk memeriksa konflik waktu
    function isTimeConflict(start1, end1, start2, end2) {
        // Konversi waktu ke menit
        const timeToMinutes = (time) => {
            const [hours, minutes] = time.split(':').map(Number);
            return hours * 60 + minutes;
        };

        const startTime1 = timeToMinutes(start1);
        const endTime1 = end1 ? timeToMinutes(end1) : startTime1 + 90; // Asumsi 90 menit jika tidak ada waktu selesai
        const startTime2 = timeToMinutes(start2);
        const endTime2 = end2 ? timeToMinutes(end2) : startTime2 + 90; // Asumsi 90 menit jika tidak ada waktu selesai

        // Periksa apakah ada tumpang tindih waktu
        return !(endTime1 <= startTime2 || endTime2 <= startTime1);
    }

    function updateIRSBadgeAndModal() {
        // Update badge
        const irsListModalElement = document.getElementById('irsListModal');
        const irsListModal = bootstrap.Modal.getInstance(irsListModalElement) || new bootstrap.Modal(irsListModalElement);
        const irsListBadge = document.getElementById('irsListBadge');
        irsListBadge.textContent = `${irsListData.length} Mata Kuliah`;
        irsListBadge.style.display = irsListData.length > 0 ? 'block' : 'none';

        // Populate modal
        const irsListModalBody = document.getElementById('irsListModalBody');
        irsListModalBody.innerHTML = ''; // Clear previous content
        irsListData.forEach(course => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${course.kode_mata_kuliah}</td>
                <td>${course.nama_mata_kuliah}</td>
                <td>${course.selectedClass.kelas || 'Default'}</td>
                <td>${course.jumlah_sks}</td>
                <td>${course.selectedClass.hari}</td>
                <td>${course.selectedClass.waktuMulai} - ${course.selectedClass.waktuSelesai || ''}</td>
                <td>${course.selectedClass.kodeRuang || 'Belum tersedia'}</td>
           
            `;
            irsListModalBody.appendChild(row);
        });

        document.querySelector('#irsListModal .btn-close').addEventListener('click', () => {
            bootstrap.Modal.getInstance(irsListModalElement).hide();
        });

        // Remove any existing listeners first to prevent multiple bindings
        irsListBadge.removeEventListener('click', openIRSListModal);
        irsListBadge.addEventListener('click', openIRSListModal);

        function openIRSListModal() {
            irsListModal.show();
        }
    }


    
    // Simpan IRS
// Simpan IRS
saveButton.addEventListener('click', async () => {
    
    const selectedCoursesData = irsListData.map(course => ({
        idJadwal: course.selectedClass.id,
        kode_mata_kuliah: course.kode_mata_kuliah,
        idThnAjaran: course.selectedClass.idThnAjaran,
        kelas: course.selectedClass.kelas,
        idProdi: course.selectedClass.idProdi
    }));

    console.log(irsListData);
console.log(selectedCoursesData);


    if (selectedCoursesData.length === 0) {
        alert('Pilih setidaknya satu mata kuliah.');
        return;
    }

    try {
        const response = await fetch('/save-irs', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                courses: selectedCoursesData,
                semester: {{ $mahasiswa->semester }},
                nim:  {{ $mahasiswa->nim }}
            }),
        });

        if (response.ok) {
            alert('IRS berhasil disimpan!');
        } else {
            const errorData = await response.json();
            alert(`Gagal menyimpan IRS: ${errorData.message || 'Silakan coba lagi.'}`);
        }
    } catch (error) {
        console.error('Error saat menyimpan IRS:', error);
        alert('Terjadi kesalahan saat menyimpan IRS.');
    }
});

});
</script>

<!-- kode lama -->