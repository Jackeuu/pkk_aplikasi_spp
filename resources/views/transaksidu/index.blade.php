@extends('master')
@section('konten')
    <div class="card">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto ma-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Data Riwayat Pembayaran</h5>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0"></div>
                        <a href="/transaksidu/history" class="btn btn-primary my-2">Riwayat Pembayaran</a>
                        <div class="table-responsive">
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
                            <input type="search" class="form-control ms-4" id="dt-search-0" placeholder="Search"
                                aria-controls="DataTables_Table_0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table mt-2">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <div class="card table-responsive w-100 m-1">
                        <table class="table mb-0" id="tabelTransaksi">
                            <thead class="table-light">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Nominal Tagihan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @foreach ($tagihan as $t)
                                    <tr>
                                        <td>{{ $t->nis }}</td>
                                        <td>{{ $t->nama_siswa }}</td>
                                        <td>Kelas {{ $t->nama_kelas }}</td>
                                        <td>Rp.{{ number_format($t->jumlah, 0, ',', '.')}}</td>
                                        <td>
                                            @if($t->status == 'Lunas')
                                                <span class="text-success fw-bold">Lunas</span>
                                            @else
                                                <span class="text-danger fw-bold">Belum Lunas</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($t->status == 'Lunas')
                                              <button onclick="alert('Tagihan sudah lunas!')" class="btn btn-success">Lunas</button>
                                            @else
                                            <x-modal modalId="bayarTagihan{{ $t->nis }}" buttonText="Bayar"
                                                title="Bayar Tagihan Siswa" url="/transaksidu/store" method="post"
                                                btnTutup="Bayar">
                                                <div class="mb-3">
                                                    <label for="nis" class="form-label">NIS</label>
                                                    <input type="text" name="nis" list="nis-list" id="nis"
                                                        placeholder="-- Masukan NIS Siswa --" class="form-control"
                                                        autocomplete="off" value="{{ $t->nis }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama Siswa</label>
                                                    <input type="text" id="nama_siswa" class="form-control" readonly
                                                        value="{{ $t->nama_siswa }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Kelas</label>
                                                    <input type="text" id="kelas_siswa" class="form-control" readonly
                                                        value="Kelas {{ $t->nama_kelas }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Nominal Daftar Ulang</label>
                                                    <input type="text" id="nominal{{ $t->nis }}" class="form-control"
                                                        name="tagihan" readonly value="{{ $t->jumlah }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Total Bayar</label>
                                                    <input type="text" id="total_bayar{{ $t->nis }}" name="bayar"
                                                        class="form-control" value="0" min="1">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Sisa</label>
                                                    <input type="text" id="sisa{{ $t->nis }}" name="sisa" class="form-control"
                                                        value="0" readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Kembali</label>
                                                    <input type="text" id="kembali{{ $t->nis }}" name="kembali"
                                                        class="form-control" value="0" readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                                </div>

                                                <script>
                                                    const sisa{{ $t->nis }} = document.getElementById('sisa{{ $t->nis }}');
                                                    const bayar{{ $t->nis }} = document.getElementById('total_bayar{{ $t->nis }}');
                                                    bayar{{ $t->nis }}.addEventListener('input', function () {
                                                        const total{{ $t->nis }} = document.getElementById('nominal{{ $t->nis }}').value;
                                                        if (bayar{{ $t->nis }}.value - total{{ $t->nis }} < 0) {
                                                            sisa{{ $t->nis }}.value = (bayar{{ $t->nis }}.value - total{{ $t->nis }}) * -1;
                                                            document.getElementById('kembali{{ $t->nis }}').value = 0;
                                                        } else {
                                                            sisa{{ $t->nis }}.value = 0;
                                                            document.getElementById('kembali{{ $t->nis }}').value = bayar{{ $t->nis }}.value - total{{ $t->nis }};
                                                        }
                                                    });
                                                </script>
                                            </x-modal>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                let nis = row.querySelector('td:nth-child(1)').innerText.toLowerCase(); // kolom NIS kolom ke-1
                row.style.display = nis.indexOf(value) > -1 ? '' : 'none';
            });
        });
    </script>

@endsection