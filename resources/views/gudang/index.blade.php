@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalGudang"
                id="btnTambahGudang">Tambah gudang</button>
        </div>
    </div>

    @include('partials.alert')

    <div class="card">
        <div class="card-header"><div class="card-title">Master gudang</div></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtGudang" class="display table table-striped table-hover">
                    <thead><tr><th>ID gudang</th><th>Nama gudang</th><th>Nomor kontrak</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($gudangs as $row)
                            <tr>
                                <td>{{ $row->idgudang }}</td>
                                <td>{{ $row->namagudang }}</td>
                                <td>{{ $row->nomorkontrak }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-gudang"
                                        data-id="{{ $row->idgudang }}" data-nama="{{ $row->namagudang }}"
                                        data-nomorkontrak="{{ $row->nomorkontrak }}"
                                        data-bs-toggle="modal" data-bs-target="#modalGudang">Ubah</button>
                                    <form action="{{ route('gudang.destroy', $row) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus gudang ini?');">
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

    <div class="modal fade" id="modalGudang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <form id="formGudang" method="post" action="{{ route('gudang.store') }}">
                @csrf
                <div id="gudangMethodField"></div>
                <div class="modal-header"><h5 class="modal-title" id="modalGudangLabel">Tambah gudang</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namagudang">Nama gudang</label>
                        <input type="text" class="form-control" id="namagudang" name="namagudang" required>
                    </div>
                    <div class="form-group">
                        <label for="nomorkontrak">Nomor kontrak</label>
                        <input type="text" class="form-control" id="nomorkontrak" name="nomorkontrak">
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
            const form = document.getElementById('formGudang');
            const methodField = document.getElementById('gudangMethodField');
            const nama = document.getElementById('namagudang');
            const kontrak = document.getElementById('nomorkontrak');
            const title = document.getElementById('modalGudangLabel');
            document.getElementById('btnTambahGudang').addEventListener('click', function() {
                form.action = @json(route('gudang.store'));
                methodField.innerHTML = '';
                nama.value = '';
                kontrak.value = '';
                title.textContent = 'Tambah gudang';
            });
            document.querySelectorAll('.btn-edit-gudang').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    form.action = @json(url('gudang')) + '/' + this.dataset.id;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    nama.value = this.dataset.nama;
                    kontrak.value = this.dataset.nomorkontrak;
                    title.textContent = 'Ubah gudang';
                });
            });
            $('#dtGudang').DataTable();
        })();
    </script>
@endpush
