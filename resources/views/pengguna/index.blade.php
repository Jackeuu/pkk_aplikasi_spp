@extends('master')
@section('konten')
  <div class="card">
    <div class="card-datatable text-nowrap">
      <div class="dt-container dt-bootstrap5 dt-empty-footer">
        <div class="row card-header flex-column flex-md-row pb-0">
          <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto ma-auto mt-0">
            <h5 class="card-title mb-0 text-md-start text-center">Data Pengguna</h5>
          </div>
          <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
            <div class="dt-buttons btn-group flex-wrap mb-0">

              <!-- ini crud insert-->
              <x-modal modalId="tambahpengguna" buttonText="+ Tambah Pengguna" title="Tambah data pengguna"
                url="pengguna/store" method="post" btnTutup="simpan data">
                <div class="mb-2">
                  <label for="" class="form-label">IDP</label>
                  <input type="text" class="form-control" placeholder="Masukkan ID Pengguna" name="id p">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Nama Pengguna</label>
                  <input type="text" class="form-control" placeholder="Masukkan Nama Pengguna" name="nama_pengguna">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">No Telepon</label>
                  <input type="text" class="form-control" placeholder="Masukkan No Telepon Pengguna" name="no_telp">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Email</label>
                  <input type="text" class="form-control" placeholder="Masukkan Email Pengguna" name="email">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Password</label>
                  <input type="password" class="form-control" placeholder="Masukkan Password Pengguna" name="password">
                </div>
                <div class="mb-2">
                  <label for="" class="form-label">Hak akses</label>
                  <input type="text" class="form-control" placeholder="Masukkan Hak Akses Pengguna" name="hak_akses">
                </div>
              </x-modal>
            </div>
          </div>
        </div>

        <!-- sampe dini krudnya -->
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
      <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
        <div class="card table-responsive w-100 m-1">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>idp</th>
                <th>nama pengguna</th>
                <th>no telp</th>
                <th>email</th>
                <th>hak akses</th>
                <th>action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pengguna as $p)
                <tr>
                  <td>{{ $p->idp }}</td>
                  <td>{{ $p->nama_pengguna }}</td>
                  <td>{{ $p->no_telp }}</td>
                  <td>{{ $p->email }}</td>
                  <td>{{ $p->hak_akses }}</td>
                  <td class="d-flex gap-2">
                    <x-modal modalId="ubahhpengguna{{ $p->idp }}" buttonText="Edit" title="edit pengguna"
                      url="pengguna/update/{{ $p->idp }}" method="PUT" btnTutup="Ubah data">
                      <div class="mb-2">
                        <label for="" class="form-label">ID Pengguna</label>
                        <input type="text" class="form-control" placeholder="Ubah id pengguna" name="idp"
                          value="{{ $p->idp}}">
                      </div>
                      <div class="mb-2">
                        <label for="" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" placeholder="Ubah Nama pengguna" name="nama_pengguna"
                          value="{{ $p->nama_pengguna }}">
                      </div>
                      <div class="mb-2">
                        <label for="" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" placeholder="Ubah Nomor telepon" name="no_telp"
                          value="{{ $p->no_telp }}">
                      </div>
                      <div class="mb-2">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Ubah email" name="email"
                          value="{{ $p->email }}">
                      </div>
                      <div class="mb-2">
                        <label for="" class="form-label">Hak Akses</label>
                        <input type="text" class="form-control" placeholder="Ubah hak akses" name="hak_akses"
                          value="{{ $p->hak_akses }}">
                      </div>
                    </x-modal>
                    <form action="{{ route('pengguna.destroy', $p->idp) }}" method="POST"
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

@endsection