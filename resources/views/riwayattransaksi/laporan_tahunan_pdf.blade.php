<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Ulang Tahun {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h2, h4 { text-align: center; margin: 0; padding: 0; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>SD Bina Insan Cendikia</h2>
    <h4>Laporan Transaksi Daftar Ulang Tahun {{ $tahun }}</h4>
    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal Bayar</th>
                <th>Total Tagihan</th>
                <th>Bayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $d)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $d->nis }}</td>
                    <td>{{ $d->nama_siswa }}</td>
                    <td>{{ $d->nama_kelas }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal_bayar)->format('d-m-Y') }}</td>
                    <td>Rp{{ number_format($d->jumlah_tagihan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($d->bayar, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($d->sisa, 0, ',', '.') }}</td>
                    <td>{{ $d->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <div style="width: 100%; text-align: right; padding-right: 40px;">
        <p>Bekasi, {{ date('d M Y') }}</p>
        <p><strong>Bendahara Sekolah</strong></p>
        <br><br>
        <p><u>_____________________</u></p>
    </div>
</body>
</html>
