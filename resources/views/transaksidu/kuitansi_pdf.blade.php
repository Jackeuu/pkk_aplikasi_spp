<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 10px; }
        table { width:100%; }
        td, th { padding: 4px; }
    </style>
</head>
<body>

<div class="header">
    <h3>KUITANSI PEMBAYARAN DAFTAR ULANG</h3>
    <small>SD Bina Insan Cendikia</small>
</div>

<table>
    <tr><th align="left">NIS</th><td>: {{ $data->nis }}</td></tr>
    <tr><th align="left">Nama</th><td>: {{ $data->nama_siswa }}</td></tr>
    <tr><th align="left">Kelas</th><td>: {{ $data->nama_kelas }}</td></tr>
    <tr><th align="left">Tagihan</th><td>: Rp.{{ number_format($data->jumlah_tagihan) }}</td></tr>
    <tr><th align="left">Bayar</th><td>: Rp.{{ number_format($data->bayar) }}</td></tr>
    <tr><th align="left">Sisa</th><td>: Rp.{{ number_format($data->sisa) }}</td></tr>
</table>

<br><br>

<div style="text-align:right;">
    <p>{{ now()->format('d M Y') }}</p>
    <br><br>
    <p>(_________________)</p>
</div>

</body>
</html>
