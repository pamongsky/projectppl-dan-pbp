<div class="col-md-2 sidebar p-0">
    <div class="p-3">
        <!-- Logo dan Label BIS UNDIP di tengah dan sedikit miring -->
        <h4 class="mb-4 text-center" >
            <img src="{{ asset('images/undip.png') }}" alt="Undip Icon" class="me-2" style="width: 40px;"> BIS UNDIP
        </h4>
        <nav class="nav flex-column">
            @php
                $selectedRole = session('selected_role'); 
            @endphp

            <!-- Sidebar Berdasarkan Role Mahasiswa -->
            @if(auth()->user()->hasRole('Mahasiswa') && (!$selectedRole || $selectedRole === 'Mahasiswa'))
                <a class="sidebar-link @if(Route::is('dashboard.mahasiswa')) active @endif" href="{{ route('dashboard.mahasiswa') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}" alt="Dashboard Icon" class="me-2"> Dashboard
                </a>
                <a class="sidebar-link @if(Route::is('registrasi')) active @endif" href="{{ route('registrasi') }}">
                    <img src="{{ asset('images/registrasi_mahasiswa_icon.png') }}" alt="Registrasi Icon" class="me-2"> Registrasi
                </a>
                <a class="sidebar-link @if(Route::is('akademik')) active @endif" href="{{ route('akademik') }}">
                    <img src="{{ asset('images/akademik_mahasiswa_icon.png') }}" alt="Akademik Icon" class="me-2"> Akademik
                </a>
            @endif

            <!-- Sidebar Berdasarkan Role Ketua Prodi -->
            @if(auth()->user()->hasRole('Ketua Prodi') && (!$selectedRole || $selectedRole === 'Ketua Prodi'))
                <a class="sidebar-link @if(Route::is('dashboard.ketua_prodi')) active @endif" href="{{ route('dashboard.ketua_prodi') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}"  class="me-2"> Dashboard
                </a>
                <a class="sidebar-link @if(Route::is('kaprodi.mahasiswa')) active @endif" href="{{ route('kaprodi.mahasiswa') }}">
                    <img src="{{ asset('images/mahasiswa_kaprodi_icon.png') }}" class="me-2"> Mahasiswa
                </a>
                <a class="sidebar-link @if(Route::is('kaprodi.mata_kuliah')) active @endif" href="{{ route('kaprodi.mata_kuliah') }}">
                    <img src="{{ asset('images/mata_kuliah_kaprodi_icon.png') }}" class="me-2"> Mata Kuliah
                </a>
                <a class="sidebar-link @if(Route::is('kaprodi.jadwal_kuliah')) active @endif" href="{{ route('kaprodi.jadwal_kuliah') }}">
                    <img src="{{ asset('images/jadwal_kuliah_kaprodi_icon.png') }}" class="me-2"> Jadwal Kuliah
                </a>
            @endif

            <!-- Sidebar Berdasarkan Bagian Akademik -->
            @if(auth()->user()->hasRole('Bagian Akademik') && (!$selectedRole || $selectedRole === 'Bagian Akademik'))
                <a class="sidebar-link @if(Route::is('dashboard.bagian_akademik')) active @endif" href="{{ route('dashboard.bagian_akademik') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}"  class="me-2"> Dashboard
                </a>
                <a class="sidebar-link @if(Route::is('ruang_kuliah.png')) active @endif" href="{{ route('ruang-kuliah.index') }}">
                    <img src="{{ asset('images/ruang_kuliah_bagianakademik_icon.png') }}" alt="Ruang Kuliah Icon" class="me-2"> Ruang Kuliah
                </a>
            @endif

            <!-- Sidebar Berdasarkan Role Dekan -->
            @if(auth()->user()->hasRole('Dekan') && (!$selectedRole || $selectedRole === 'Dekan'))
                <a class="sidebar-link @if(Route::is('dashboard.dekan')) active @endif" href="{{ route('dashboard.dekan') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}"  class="me-2"> Dashboard
                </a>
                <a class="sidebar-link @if(Route::is('dekan.ruang_kuliah')) active @endif" href="{{ route('dekan.ruangan') }}">
                    <img src="{{ asset('images/ruang_kuliah.png') }}" alt="Ruang Kuliah Icon" class="me-2"> Ruang Kuliah
                </a>
                <a class="sidebar-link @if(Route::is('dekan.jadwal_kuliah')) active @endif" href="{{ route('dekan.JadwalPerProdi') }}">
                    <img src="{{ asset('images/jadwal_kuliah_dekan_icon.png') }}" alt="Jadwal Kuliah Icon" class="me-2"> Jadwal Kuliah
                </a>
            @endif

            <!-- Sidebar Berdasarkan Role Dosen Pembimbing -->
            @if(auth()->user()->hasRole('Pembimbing Akademik') && (!$selectedRole || $selectedRole === 'Pembimbing Akademik'))
                <a class="sidebar-link @if(Route::is('dashboard.pembimbing_akademik')) active @endif" href="{{ route('dashboard.pembimbing_akademik') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}"  class="me-2"> Dashboard
                </a>
                <a class="sidebar-link @if(Route::is('pa.perwalian')) active @endif" href="{{ route('pa.perwalian') }}">
                    <img src="{{ asset('images/perwalian_dosen_icon.png') }}" alt="Perwalian Dosen Icon" class="me-2"> Perwalian
                </a>
                <a class="sidebar-link @if(Route::is('pa.ajuanIRS')) active @endif" href="{{ route('pa.ajuanIRS') }}">
                <img src="{{ asset('images/jadwal_kuliah_dekan_icon.png') }}" alt="Jadwal Kuliah Icon"  class="me-2"> Ajuan IRS
                </a>
            @endif
        </nav>

        <!-- Logout -->
        <div class="mt-auto">
        <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-top: 6cm;">
        <img src="{{ asset('images/logout_icon.png') }}" alt="Logout Icon" class="me-2"> Logout
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
        </div>
    </div>
</div>
