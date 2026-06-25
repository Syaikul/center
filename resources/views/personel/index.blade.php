@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalPersonel"
                id="btnTambahPersonel">Tambah personel</button>
        </div>
    </div>

    @include('partials.alert')

    <div class="card">
        <div class="card-header"><div class="card-title">Master personel</div></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtPersonel" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama personel</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personels as $row)
                            <tr>
                                <td><code>{{ $row->nik }}</code></td>
                                <td>{{ $row->namapersonel }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-personel"
                                        data-id="{{ $row->idpersonel }}"
                                        data-nik="{{ $row->nik }}"
                                        data-nama="{{ $row->namapersonel }}"
                                        data-bs-toggle="modal" data-bs-target="#modalPersonel">Ubah</button>
                                    <form action="{{ route('personel.destroy', $row) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus personel ini?');">
                                        @csrf @method('DELETE')
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

    <div class="modal fade" id="modalPersonel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <form id="formPersonel" method="post" action="{{ route('personel.store') }}">
                @csrf
                <div id="personelMethodField"></div>
                <div class="modal-header"><h5 class="modal-title" id="modalPersonelLabel">Tambah personel</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nik">NIK <span class="text-muted fw-normal">(Nomor Id Karyawan)</span></label>
                        <input type="text" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="form-group">
                        <label for="namapersonel">Nama personel</label>
                        <input type="text" class="form-control" id="namapersonel" name="namapersonel" required>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
            </form>
        </div></div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const form = document.getElementById('formPersonel');
            const methodField = document.getElementById('personelMethodField');
            const nik = document.getElementById('nik');
            const nama = document.getElementById('namapersonel');
            const title = document.getElementById('modalPersonelLabel');

            document.getElementById('btnTambahPersonel').addEventListener('click', function() {
                form.action = @json(route('personel.store'));
                methodField.innerHTML = '';
                nik.value = '';
                nama.value = '';
                title.textContent = 'Tambah personel';
            });

            document.querySelectorAll('.btn-edit-personel').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    form.action = @json(url('personel')) + '/' + this.dataset.id;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    nik.value = this.dataset.nik;
                    nama.value = this.dataset.nama;
                    title.textContent = 'Ubah personel';
                });
            });

            $('#dtPersonel').DataTable();
        })();
    </script>
@endpush
