@extends('master')
@section('konten')
<div class="container">
    <h3>Kuitansi Pembayaran Daftar Ulang</h3>
    <hr>

    <table class="table">
        <tr><th>NIS</th><td>{{ $data->nis }}</td></tr>
        <tr><th>Nama</th><td>{{ $data->nama_siswa }}</td></tr>
        <tr><th>Kelas</th><td>{{ $data->nama_kelas }}</td></tr>
        <tr><th>Total Tagihan</th><td>Rp.{{ number_format($data->jumlah_tagihan) }}</td></tr>
        <tr><th>Bayar</th><td>Rp.{{ number_format($data->bayar) }}</td></tr>
        <tr><th>Sisa Tagihan</th><td>Rp.{{ number_format($data->sisa) }}</td></tr>
        <tr><th>Status</th><td>{{ $data->status }}</td></tr>
    </table>

    <a href="{{ route('daftarulang.kuitansi.pdf', $data->id) }}" class="btn btn-success" target="_blank">
        Cetak PDF
    </a>
</div>
@endsection