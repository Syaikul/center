@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalSatuan"
                id="btnTambahSatuan">Tambah satuan</button>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="card-title">Master satuan</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtSatuan" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID satuan</th>
                            <th>Nama satuan</th>
                            <th class="text-end" style="width: 160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($satuans as $row)
                            <tr>
                                <td>{{ $row->idsatuan }}</td>
                                <td>{{ $row->nama_satuan }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-satuan"
                                        data-id="{{ $row->idsatuan }}" data-nama="{{ $row->nama_satuan }}"
                                        data-bs-toggle="modal" data-bs-target="#modalSatuan">Ubah</button>
                                    <form action="{{ route('satuan.destroy', $row) }}" method="post" class="d-inline"
                                        onsubmit="return confirm('Hapus satuan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSatuan" tabindex="-1" aria-labelledby="modalSatuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formSatuan" method="post" action="{{ route('satuan.store') }}">
                    @csrf
                    <div id="satuanMethodField"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSatuanLabel">Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_satuan">Nama satuan</label>
                            <input type="text" class="form-control" id="nama_satuan" name="nama_satuan"
                                value="{{ old('nama_satuan') }}" required maxlength="191">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const modalEl = document.getElementById('modalSatuan');
            const form = document.getElementById('formSatuan');
            const methodContainer = document.getElementById('satuanMethodField');
            const namaInput = document.getElementById('nama_satuan');
            const modalTitle = document.getElementById('modalSatuanLabel');

            function resetFormCreate() {
                form.action = @json(route('satuan.store'));
                methodContainer.innerHTML = '';
                namaInput.value = '';
                modalTitle.textContent = 'Tambah satuan';
            }

            document.getElementById('btnTambahSatuan').addEventListener('click', function() {
                resetFormCreate();
            });

            document.querySelectorAll('.btn-edit-satuan').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    form.action = @json(url('satuan')) + '/' + id;
                    methodContainer.innerHTML =
                        '<input type="hidden" name="_method" value="PUT" autocomplete="off">';
                    namaInput.value = nama;
                    modalTitle.textContent = 'Ubah satuan';
                });
            });

            modalEl.addEventListener('hidden.bs.modal', function() {
                resetFormCreate();
            });

            $(document).ready(function() {
                $('#dtSatuan').DataTable({
                    pageLength: 10,
                    order: [
                        [1, 'asc']
                    ],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ data',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data',
                        paginate: {
                            first: 'Pertama',
                            last: 'Terakhir',
                            next: 'Selanjutnya',
                            previous: 'Sebelumnya'
                        },
                        zeroRecords: 'Tidak ada data yang cocok'
                    }
                });
            });
        })();
    </script>
@endpush
