@extends('master')
@section('konten')

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif



  <div class="card">
    <div class="card-datatable text-nowrap">
      <div class="dt-container dt-bootstrap5 dt-empty-footer">
        <div class="row card-header flex-column flex-md-row pb-0">
          <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto ma-auto mt-0">
            <h5 class="card-title mb-0 text-md-start text-center">Data Siswa</h5>
          </div>
          <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
            <div class="dt-buttons btn-group flex-wrap mb-0">
              <form action="{{ route('naik.kelas') }}" method="POST" onsubmit="return confirm('Yakin ingin naikkan semua siswa ke kelas berikutnya?')">
                @csrf
                <button type="submit" class="btn btn-success me-2">Naikkan Semua Kelas</button>
              </form>
              <x-modal modalId="tambahsiswa" buttonText="+ Tambah Siswa" title="Tambah Data Siswa" url="/siswa/stored"
                method="post" btnTutup="simpan data">

                <div class="mb-2">
                  <label for="" class="form-label">NIS</label>
                  <input type="text" class="form-control" placeholder="Masukkan Nis siswa" name="nis">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Nama Siswa</label>
                  <input type="text" class="form-control" placeholder="Masukkan nama siswa" name="nama_siswa">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Kelas</label>
                  <input type="text" class="form-control" placeholder="Masukkan kelas siswa" name="idk">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Jenis kelamin</label>
                  <select class="form-select" name="jenis_kelamin" aria-label="Default select example" required>
                    <option value="">-- Pilih jenis kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">alamat</label>
                  <input type="text" class="form-control" placeholder="Masukkan alamat siswa" name="alamat">
                </div>
              </x-modal>

            </div>
          </div>
        </div>
        <div class="row m-3 my-0 justify-content-between align-items-center mt-4">
          <div class="d-md-flex align-items-center dt-layout-start col-md-auto me-auto mt-0">
            <div class="dt-length d-flex align-items-center">
              <label for="dt-length-0">Tampil</label>
              <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select ms-2"
                id="dt-length-0">
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
                <tr>
                  <th>nis</th>
                  <th>nama siswa</th>
                  <th>kelas</th>
                  <th>jenis kelamin</th>
                  <th>alamat</th>
                  <th>idspp</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($siswa as $s)
                  <tr>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->nama_siswa }}</td>
                    <td>{{ $s->idk }}</td>
                    <td>{{ $s->jenis_kelamin }}</td>
                    <td>{{ $s->alamat }}</td>
                    <td>SPP00{{ $s->idspp }}</td>
                    <td class="d-flex gap-2">
                      <x-modal modalId="ubahhsiswa{{ $s->nis }}" buttonText="edit" title="edit siswa"
                        url="siswa/update/{{ $s->nis }}" method="PUT" btnTutup="Ubah data">
                        <div class="mb-2">
                          <label for="" class="form-label">NIS</label>
                          <input type="text" class="form-control" placeholder="Masukkan nis" name="nis"
                            value="{{  $s->nis}}">
                        </div>
                        <div class="mb-2">
                          <label for="" class="form-label">Nama Siswa</label>
                          <input type="text" class="form-control" placeholder="Masukkan nama siswa" name="nama_siswa"
                            value="{{  $s->nama_siswa}}">
                        </div>
                        <div class="mb-2">
                          <label for="" class="form-label">Kelas</label>
                          <input type="text" class="form-control" placeholder="Masukkan Kelas" name="idk"
                            value="{{  $s->idk}}">
                        </div>
                        <div class="mb-2">
                          <label for="" class="form-label">Jenis Kelamin</label>
                          <select name="jenis_kelamin" class="form-control">
                            <option value="laki-laki" {{ $s->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="perempuan" {{ $s->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                          </select>
                        </div>
                        <div class="mb-2">
                          <label for="" class="form-label">Alamat</label>
                          <input type="text" class="form-control" placeholder="Masukkan Kelas" name="alamat"
                            value="{{  $s->alamat}}">
                        </div>
                        <div class="mb-2">
                          <label for="" class="form-label">IDSPP</label>
                          <input type="text" class="form-control" placeholder="Masukkan idspp" name="idspp"
                            value="{{  $s->idspp}}">
                        </div>

                      </x-modal>
                      <form action="{{ route('siswa.destroy', $s->nis) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="row mx-3 justify-content-between mt-2">
          <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
            <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status"></div>
          </div>
          <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
            <div class="dt-paging">
              <nav aria-label="pagination">
                <ul class="pagination">
                  <li class="dt-paging-button page-item disabled">
                    <button class="page-link previous" role="link" type="button" aria-controls="DataTables_Table_0"
                      aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1">
                      <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>
                    </button>
                  </li>
                  <li class="dt-paging-button page-item">
                    <button class="page-link next" role="link" type="button" aria-controls="DataTables_Table_0"
                      aria-label="Next" data-dt-idx="next">
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