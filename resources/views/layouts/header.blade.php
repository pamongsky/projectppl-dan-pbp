<div class="header d-flex justify-content-between align-items-center p-3" style="background-color: #2AB7A9; border-bottom: 2px solid #E0E0E0; color: white;">
    <!-- Judul Halaman -->
    <div>
        <h4 class="mb-0">@yield('header-title',)</h4>
    </div>

    <!-- Profil Pengguna dan Notifikasi -->
    <div class="d-flex align-items-center">
        <!-- Notifikasi -->
        <div class="me-3">
            <a href="#" class="text-white">
                <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
            </a>
        </div>

        <!-- Dropdown Profil -->
        <div class="dropdown">
            <a class="d-flex align-items-center text-decoration-none text-white dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <!-- Foto Profil -->
                <img src="{{ asset('images/photo_profile.png') }}" alt="Foto Profil" class="rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;">
                <!-- Nama Pengguna -->
                <span>Zahidan Aqila</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="#">Profil</a></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</div>
