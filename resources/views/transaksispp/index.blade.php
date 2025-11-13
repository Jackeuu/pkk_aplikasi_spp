@extends('master')
@section('konten')
    <div class="card">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Data Kelas</h5>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0">

                            <x-modal modalId="tambahtspp" buttonText="+ Tambah Transaksi" title="Tambah Data Transaksi SPP"
                                url="/transaksispp/store" method="post" btnTutup="simpan data">
                                <!-- <div class="mb-3">
                                        <label for="nis" class="form-label">NIS</label>
                                        <select name="nis" id="nis" class="form-control">
                                            <option value="">-- Pilih NIS Siswa --</option>
                                            @foreach ($siswas as $siswa)
                                                <option value="{{ $siswa->nis }}">{{ $siswa->nis }}</option>
                                            @endforeach
                                        </select>
                                    </div> -->
                                <div class="mb-3">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" name="nis" list="nis-list" id="nis"
                                        placeholder="-- Masukan NIS Siswa --" class="form-control" autocomplete="off">

                                    <datalist id="nis-list">
                                        @foreach ($siswas as $siswa)
                                            <option value="{{ $siswa->nis }}">
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Siswa</label>
                                    <input type="text" id="nama_siswa" class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Kelas</label>
                                    <input type="text" id="kelas_siswa" class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Nominal SPP</label>
                                    <input type="text" id="nominal_spp" class="form-control" readonly>
                                </div>

                                <!--  -->
                                <div class="mb-2">
                                    <label for="" class="form-label">Bulan</label>
                                    <select class="form-select" name="bulan[]" id="bulan" multiple required>
                                        <option selected disabled>Pilih Bulan</option>
                                        @foreach ($bulans as $bulan)
                                            <option value="{{ $bulan->No }}">{{ $bulan->Bulan }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Tekan CTRL untuk memilih lebih dari satu bulan</small>
                                </div>
                            </x-modal>
                        </div>
                    </div>
                </div>
                <div class="row m-3 my-0 justify-content-between align-items-center mt-4">
                    <div class="d-md-flex align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length d-flex align-items-center">
                            <label for="dt-length-0">Tampil</label>
                            <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                class="form-select ms-2" id="dt-length-0">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-search d-flex align-items-center">
                            <form action="{{ route('transaksispp.cetak') }}" method="GET" class="d-flex align-items-center gap-2">
                                <select name="bulan" class="form-select">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>

                                </select>
                                <button class="btn btn-success mt-2">Cetak Laporan</button>
                            </form>
                            <input type="search" class="form-control ms-4" id="dt-search-0" placeholder="Search"
                                aria-controls="DataTables_Table_0">
                        </div>

                    </div>
                </div>
            </div>

            <div class="justify-content-between dt-layout-table mt-2">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <div class="card table-responsive w-100 m-1">
                        <table class="table mb-0"  id="tabelTransaksi">
                            <thead class="table-light">
                                <tr>
                                    <th>nis</th>
                                    <th>tanggal bayar</th>
                                    <th>petugas</th>
                                    <th>bulan</th>
                                    <th>tahun bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksiSpp as $ts)
                                    <tr>
                                        <td>{{ $ts->nis }}</td>
                                        <td>{{ $ts->tanggalBayar }}</td>
                                        <td>{{ $ts->nama_pengguna }}</td>
                                        @php
                                            $namaBulan = [
                                                1 => 'Januari',
                                                2 => 'Februari',
                                                3 => 'Maret',
                                                4 => 'April',
                                                5 => 'Mei',
                                                6 => 'Juni',
                                                7 => 'Juli',
                                                8 => 'Agustus',
                                                9 => 'September',
                                                10 => 'Oktober',
                                                11 => 'November',
                                                12 => 'Desember',
                                            ];
                                        @endphp
                                        <td>{{ $namaBulan[$ts->bulan] ?? '-' }}</td>
                                        <td>{{ $ts->tahunBayar }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($pesan = Session::get('error'))
                        <script>
                            Swal.fire({
                                title: "{{ $pesan  }}",
                                icon: "error",
                                draggable: true
                            });
                        </script>
                    @endif


                    <!-- fungsi ini tuh buat kalo ngisi nis langsung muncul nama kelas dan nominal spp yg harus dibayar -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $('#nis').on('change', function () {
                            var nis = $(this).val();
                            if (nis) {
                                $.ajax({
                                    url: '/get-siswa/' + nis,
                                    type: 'GET',
                                    success: function (response) {
                                        if (response.success) {
                                            $('#nama_siswa').val(response.data.nama_siswa);
                                            $('#kelas_siswa').val(response.data.idk);
                                            $('#nominal_spp').val(response.data.nominal);
                                        } else {
                                            $('#nama_siswa').val('');
                                            $('#kelas_siswa').val('');
                                            $('#nominal_spp').val('');
                                            alert(response.message);
                                        }
                                    }
                                });
                            } else {
                                $('#nama_siswa').val('');
                                $('#kelas_siswa').val('');
                                $('#nominal_spp').val('');
                            }
                        });
                    </script>
                </div>
                <div class="row mx-3 justify-content-between mt-2">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status"></div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    <li class="dt-paging-button page-item disabled">
                                        <button class="page-link previous" role="link" type="button"
                                            aria-controls="DataTables_Table_0" aria-disabled="true" aria-label="Previous"
                                            data-dt-idx="previous" tabindex="-1">
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>
                                        </button>
                                    </li>
                                    <li class="dt-paging-button page-item">
                                        <button class="page-link next" role="link" type="button"
                                            aria-controls="DataTables_Table_0" aria-label="Next" data-dt-idx="next">
                                            <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dt-search-0').addEventListener('keyup', function () {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tabelTransaksi tbody tr');

            rows.forEach(function (row) {
                let nis = row.querySelector('td:nth-child(1)').innerText.toLowerCase(); // Untukk kolom NIS kolom ke 1
                row.style.display = nis.indexOf(value) > -1 ? '' : 'none';
            });
        });
    </script>



@endsection