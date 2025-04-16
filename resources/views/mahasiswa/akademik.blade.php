@extends('layouts.layout')

@section('title', 'Akademik')

@section('content')
    <!-- Konten Akademik -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .sks-badge {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #2ca58d;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }
        .semester-header {
            cursor: pointer;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .semester-details {
            display: none;
        }
    </style>
    <div class="container mt-4">
        <!-- Tab Navigasi untuk Halaman Akademik -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" onclick="showPage('isiIRS', this)">Isi IRS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showPage('irs', this)">IRS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showPage('khs', this)">KHS</a>
            </li>
        </ul>

        <!-- Konten Halaman Akademik -->
        <div class="page-content" id="isiIRS" style="display: {{ $rekapIrs && $rekapIrs->status === 'disetujui' ? 'none' : 'block' }};">
            @if($rekapIrs && $rekapIrs->status === 'disetujui' && $rekapIrs->semester == 3)
                    @include('mahasiswa.perubahanIRS')

            @else
                @include('mahasiswa.isi_irs', ['rekapIrs' => $rekapIrs, 'canMakeChanges' => $canMakeChanges])
            @endif
        </div>

        <div class="page-content" id="irs" style="display: none;">
            @include('mahasiswa.irs')
        </div>

        <div class="page-content" id="khs" style="display: none;">
            @include('mahasiswa.khs')
        </div>
    </div>

    <script>
    function showPage(pageId, element) {
        const pages = document.querySelectorAll('.page-content');
        pages.forEach(page => {
            page.style.display = 'none';
        });
        document.getElementById(pageId).style.display = 'block';

        const tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        element.classList.add('active');
    }
</script>

@endsection