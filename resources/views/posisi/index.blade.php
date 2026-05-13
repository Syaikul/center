@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalPosisi"
                id="btnTambahPosisi">Tambah posisi</button>
        </div>
    </div>

    @include('partials.alert')

    <div class="card">
        <div class="card-header"><div class="card-title">Master posisi</div></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtPosisi" class="display table table-striped table-hover">
                    <thead><tr><th>ID posisi</th><th>Nama posisi</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($posisis as $row)
                            <tr>
                                <td>{{ $row->idposisi }}</td>
                                <td>{{ $row->namaposisi }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-posisi"
                                        data-id="{{ $row->idposisi }}" data-nama="{{ $row->namaposisi }}"
                                        data-bs-toggle="modal" data-bs-target="#modalPosisi">Ubah</button>
                                    <form action="{{ route('posisi.destroy', $row) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus posisi ini?');">
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

    <div class="modal fade" id="modalPosisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <form id="formPosisi" method="post" action="{{ route('posisi.store') }}">
                @csrf
                <div id="posisiMethodField"></div>
                <div class="modal-header"><h5 class="modal-title" id="modalPosisiLabel">Tambah posisi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaposisi">Nama posisi</label>
                        <input type="text" class="form-control" id="namaposisi" name="namaposisi" required>
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
            const form = document.getElementById('formPosisi');
            const methodField = document.getElementById('posisiMethodField');
            const nama = document.getElementById('namaposisi');
            const title = document.getElementById('modalPosisiLabel');
            document.getElementById('btnTambahPosisi').addEventListener('click', function() {
                form.action = @json(route('posisi.store'));
                methodField.innerHTML = '';
                nama.value = '';
                title.textContent = 'Tambah posisi';
            });
            document.querySelectorAll('.btn-edit-posisi').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    form.action = @json(url('posisi')) + '/' + this.dataset.id;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    nama.value = this.dataset.nama;
                    title.textContent = 'Ubah posisi';
                });
            });
            $('#dtPosisi').DataTable();
        })();
    </script>
@endpush
