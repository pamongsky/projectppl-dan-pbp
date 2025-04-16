<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar dengan posisi fixed di kiri layar */
        .sidebar { 
            background-color: #2AB7A9; 
            min-height: 100vh; 
            color: white;
            position: fixed; /* Menetapkan posisi fixed */
            top: 0; /* Sidebar tetap di bagian atas */
            left: 0; /* Sidebar berada di sisi kiri */
            height: 100vh; /* Sidebar sepanjang tinggi layar */
            overflow-y: auto; /* Jika konten di sidebar lebih panjang, tampilkan scroll */
            width: 250px; /* Lebar sidebar yang tetap */
            z-index: 1000; /* Menjaga sidebar tetap di atas konten */
        }

        /* Link di dalam sidebar */
        .sidebar-link { 
            color: white; 
            text-decoration: none; 
            padding: 10px 20px; 
            display: block; 
            margin: 5px 0; 
        }

        /* Hover atau aktif pada link */
        .sidebar-link:hover, .sidebar-link.active { 
            background-color: #1E8679; 
            border-radius: 5px; 
        }

        .header {
            background-color: #1E8679 !important; /* Warna lebih gelap */
            color: white;
            border-bottom: 2px solid #E0E0E0 ;
            padding: 5px 20px; 
            font-size: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 250px;
            width: calc(100% - 30px);
            margin-left: 250px;
        }

        /* Konten utama diberi margin kiri agar tidak tertutup sidebar */
        .main-content { 
            background-color: #F8F9FA; 
            width: calc(100% - 30px);
            min-height: 100px; 
            padding: 60px; 
            margin-left: 250px; /* Memberikan ruang di kiri sesuai dengan lebar sidebar */
        }

        /* Nav di dalam sidebar dengan scroll jika konten lebih panjang */
        .sidebar nav {
            max-height: calc(100vh - 100px); /* Membatasi tinggi sidebar agar tetap proporsional */
            overflow-y: auto; /* Menambahkan scroll pada sidebar jika konten panjang */
        }

        


        

        /* body {
            background-color: #f8f9fa; /* Ganti dengan warna abu-abu yang Anda inginkan */
        /* } */ 

        /* Profile card */
        .profile-card {
            background-color: #FFFFFF;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .profile-pic {
            width: 80px;
            height: 80px;
            background-color: #FFD700;
            border-radius: 50%;
        }

        /* Stat box styling */
        .stat-box {
            background-color: #FFFFFF;
            border: 1px solid #37A99C;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        /* Announcement styling */
        .announcement-section {
            background-color: #FFFFFF;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-container {
            background-color: #E8F6F4;
            border-radius: 15px;
            padding: 20px;
        }

        .status-icon {
            width: 60px;
            height: 60px;
            background-color: #2AB7A9;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
        }

        .status-badge {
            background-color: #28A745;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
        }

        .status-badge.cuti {
            background-color: #DC3545;
        }

        .academic-status {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        input::placeholder {
            color: rgba(0, 0, 0, 0.5); /* Warna hitam dengan transparansi 50% */
            font-style: italic; /* Opsional, untuk menambahkan gaya miring */
        }   

        /* Warna badge untuk status */
        .badge.bg-transparent {
            background-color: transparent;
            color: #888;
        }

        .badge.bg-success {
            background-color: #28a745;
            color: white;
        }

        .badge.bg-warning {
            background-color: #ffc107;
            color: white;
        }

        .badge.bg-danger {
            background-color: #dc3545;
            color: white;
        }


        /* Halaman Mahasiswa */
        /* Memperbaiki ukuran dan posisi simbol < dan > */
        .pagination .page-link {
            font-size: 14px;  /* Ukuran font untuk tombol pagination */
            padding: 6px 10px;  /* Padding kecil untuk tombol */
        }

        /* Memperbaiki ukuran simbol < dan > */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 12px;  /* Ukuran font untuk simbol < dan > */
            padding: 6px 8px;  /* Padding lebih kecil untuk simbol */
        }

        /* Menyusun pagination lebih rapi */
        .pagination {
            margin: 0;  /* Hilangkan margin default */
            justify-content: center;  /* Posisikan pagination di tengah */
        }

        /* Menjaga jarak antar tombol pagination */
        .pagination .page-item {
            margin: 0 5px;  /* Beri jarak antar elemen */
        }

        /* Menyesuaikan input halaman */
        .pagination input {
            width: 40px;  /* Mengatur lebar kotak input untuk halaman */
            height: 30px;  /* Menyesuaikan tinggi kotak input */
            text-align: center;  /* Agar angka berada di tengah */
            border: 1px solid #ddd;  /* Border tipis */
            font-size: 14px;  /* Ukuran font angka */
            margin: 0 5px;  /* Jarak antar input */
        }

        /* Menambahkan efek hover untuk tombol */
        .pagination .page-link:hover {
            background-color: #f1f1f1;  /* Warna background saat hover */
            border-color: #ccc;  /* Border saat hover */
        }

        /* Menyusun tombol aktif agar lebih jelas */
        .pagination .page-item.active .page-link {
            background-color: #007bff;  /* Warna background aktif */
            color: white;  /* Warna teks tombol aktif */
            border-color: #007bff;  /* Border aktif */
        }

        /* Mengubah warna ketika tombol disabled */
        .pagination .page-item.disabled .page-link {
            color: #ccc;  /* Warna tombol disabled */
            border-color: #ddd;  /* Border disabled */
        }

        /* Styling tabel */
        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #1E8679; /* Warna header tabel */
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .table td {
            text-align: center;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Styling untuk status */
        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-muted {
            color: #6c757d;
        }

        /* Optional: Padding pada tabel */
        .table td, .table th {
            padding: 12px;
        }

    </style>
</head>
<body>
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="col-md-10 p-0">
            <!-- Header -->
            @include('layouts.header')

            <!-- Page Content -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
