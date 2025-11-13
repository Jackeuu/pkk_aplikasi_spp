@extends('master')

@section('konten')
<div class="container-fluid">

    <h3 class="mb-4">Selamat Datang, {{ Auth::user()->nama }} 👋</h3>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center py-4">
                    <h6 class="text-muted mb-1">Total Pengguna</h6>
                    <h2 class="fw-bold">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center py-4">
                    <h6 class="text-muted mb-1">Total Siswa</h6>
                    <h2 class="fw-bold">{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center py-4">
                    <h6 class="text-muted mb-1">Total Kelas</h6>
                    <h2 class="fw-bold">{{ $totalKelas }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center py-4">
                    <h6 class="text-muted mb-1">Total Transaksi</h6>
                    <h2 class="fw-bold">{{ $totalTransaksispp }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-3">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0">
                    <strong>Informasi Sekolah</strong>
                </div>
                <div class="card-body">
                    <p>Sistem Informasi Pembayaran SPP - SD Bina Insan Cendikia</p>
                    <p>Gunakan menu di kiri untuk mengelola data dan transaksi pembayaran siswa.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0">
                    <strong>Aktivitas Terbaru</strong>
                </div>
                <div class="card-body">

                    

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
