@extends('master')

@section('konten')
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">
                Selamat Datang, {{ Auth::user()->nama_pengguna }}! 👋
              </h5>
              <p class="mb-4">
                Sistem Informasi Pembayaran SPP - SD Bina Insan Cendikia
              </p>
              <a href="{{ url('siswa') }}" class="btn btn-sm btn-outline-primary">
                Lihat Data Siswa
              </a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140" alt="User" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Informasi Sekolah dan Aktivitas --}}
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-3">Informasi Sekolah</h5>
          <p>
            Sistem ini digunakan untuk mengelola data siswa, pembayaran SPP, dan daftar ulang SD Bina Insan Cendikia.
            </p>
            <p>Alamat   : Leuwigajah, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40532</p>
            <p>Jam      : Buka ⋅ Tutup pukul 14.30</p>
            <p>Provinsi : Jawa Barat</p>
            <p>Sekolah pendidikan umum di Jawa Barat</p>
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-3">Aktivitas Terbaru</h5>
          <ul class="list-group">
            @forelse($logs as $log)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ $log->user }}</strong> — {{ $log->aksi }}
                </div>
                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
              </li>
            @empty
              <li class="list-group-item text-muted text-center">Belum ada aktivitas terbaru</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>

  {{-- Grafik Transaksi di bawah informasi --}}
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-3">Grafik Transaksi Pembayaran</h5>
          <canvas id="grafikTransaksi" height="100"></canvas>
        </div>
      </div>
    </div>
  </div>
@endsection

{{-- Script Chart.js --}}
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('grafikTransaksi').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($bulan),
        datasets: [
          {
            label: 'Transaksi SPP',
            data: @json($dataSpp),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          },
          {
            label: 'Transaksi Daftar Ulang',
            data: @json($dataDaftarUlang),
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  </script>
@endsection