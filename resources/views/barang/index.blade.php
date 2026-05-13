@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalBarang"
                id="btnTambahBarang">Tambah barang</button>
        </div>
    </div>

    @include('partials.alert')

    <div class="card">
        <div class="card-header">
            <div class="card-title">Master barang</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtBarang" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID barang</th>
                            <th>Kode barang</th>
                            <th>Nama barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $row)
                            <tr>
                                <td>{{ $row->idbarang }}</td>
                                <td>{{ $row->kodebarang }}</td>
                                <td>{{ $row->namabarang }}</td>
                                <td>{{ $row->kategori?->nama_kategori }}</td>
                                <td>{{ $row->satuan?->nama_satuan }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-barang"
                                        data-id="{{ $row->idbarang }}" data-kode="{{ $row->kodebarang }}"
                                        data-nama="{{ $row->namabarang }}"
                                        data-idkategori="{{ $row->idkategori }}" data-idsatuan="{{ $row->idsatuan }}"
                                        data-bs-toggle="modal" data-bs-target="#modalBarang">Ubah</button>
                                    <form action="{{ route('barang.destroy', $row) }}" method="post" class="d-inline"
                                        onsubmit="return confirm('Hapus barang ini?');">
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

    <div class="modal fade" id="modalBarang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formBarang" method="post" action="{{ route('barang.store') }}">
                    @csrf
                    <div id="barangMethodField"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBarangLabel">Tambah barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kodebarang">Kode barang</label>
                            <input type="text" class="form-control" id="kodebarang" name="kodebarang" required>
                        </div>
                        <div class="form-group">
                            <label for="namabarang">Nama barang</label>
                            <input type="text" class="form-control" id="namabarang" name="namabarang" required>
                        </div>
                        <div class="form-group">
                            <label for="idkategori">Kategori</label>
                            <select class="form-select" id="idkategori" name="idkategori" required>
                                <option value="">- pilih kategori -</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->idkategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="idsatuan">Satuan</label>
                            <select class="form-select" id="idsatuan" name="idsatuan" required>
                                <option value="">- pilih satuan -</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->idsatuan }}">{{ $satuan->nama_satuan }}</option>
                                @endforeach
                            </select>
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
            const form = document.getElementById('formBarang');
            const methodField = document.getElementById('barangMethodField');
            const kode = document.getElementById('kodebarang');
            const nama = document.getElementById('namabarang');
            const idkategori = document.getElementById('idkategori');
            const idsatuan = document.getElementById('idsatuan');
            const title = document.getElementById('modalBarangLabel');

            document.getElementById('btnTambahBarang').addEventListener('click', function() {
                form.action = @json(route('barang.store'));
                methodField.innerHTML = '';
                kode.value = '';
                nama.value = '';
                idkategori.value = '';
                idsatuan.value = '';
                title.textContent = 'Tambah barang';
            });

            document.querySelectorAll('.btn-edit-barang').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    form.action = @json(url('barang')) + '/' + this.dataset.id;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    kode.value = this.dataset.kode;
                    nama.value = this.dataset.nama;
                    idkategori.value = this.dataset.idkategori;
                    idsatuan.value = this.dataset.idsatuan;
                    title.textContent = 'Ubah barang';
                });
            });

            $('#dtBarang').DataTable();
        })();
    </script>
@endpush
