@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalVarian"
                id="btnTambahVarian">Tambah varian</button>
        </div>
    </div>

    @include('partials.alert')

    <div class="card">
        <div class="card-header">
            <div class="card-title">Master barang varian</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtBarangVarian" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID varian</th>
                            <th>Kode lengkap</th>
                            <th>Nama barang</th>
                            <th>Nama varian</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($varians as $row)
                            <tr>
                                <td>{{ $row->idvarian }}</td>
                                <td><code>{{ $row->kode_lengkap }}</code></td>
                                <td>{{ $row->barang?->namabarang }}</td>
                                <td>{{ $row->namavarian }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-varian"
                                        data-id="{{ $row->idvarian }}" data-idbarang="{{ $row->idbarang }}"
                                        data-kodevarian="{{ $row->kodevarian }}" data-namavarian="{{ $row->namavarian }}"
                                        data-bs-toggle="modal" data-bs-target="#modalVarian">Ubah</button>
                                    <form action="{{ route('barang-varian.destroy', $row) }}" method="post" class="d-inline"
                                        onsubmit="return confirm('Hapus varian ini?');">
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

    <div class="modal fade" id="modalVarian" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formVarian" method="post" action="{{ route('barang-varian.store') }}">
                    @csrf
                    <div id="varianMethodField"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalVarianLabel">Tambah varian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="idbarang">Barang</label>
                            <select class="form-select" id="idbarang" name="idbarang" required>
                                <option value="">- pilih barang -</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->idbarang }}" data-kode="{{ $barang->kodebarang }}">
                                        {{ $barang->namabarang }} ({{ $barang->kodebarang }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kodevarian">Kode varian</label>
                            <input type="text" class="form-control" id="kodevarian" name="kodevarian"
                                placeholder="contoh: 9.0" required>
                            <small class="text-muted">Dilanjutkan setelah kode barang, mis. 1.1.1 + 9.0</small>
                        </div>
                        <div class="form-group">
                            <label for="namavarian">Nama varian</label>
                            <input type="text" class="form-control" id="namavarian" name="namavarian"
                                placeholder="contoh: ukuran XL" required>
                        </div>
                        <div class="alert alert-light border mb-0">
                            <strong>Preview kode lengkap:</strong>
                            <code id="previewKodeLengkap">-</code>
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
            const form = document.getElementById('formVarian');
            const methodField = document.getElementById('varianMethodField');
            const idbarang = document.getElementById('idbarang');
            const kodevarian = document.getElementById('kodevarian');
            const namavarian = document.getElementById('namavarian');
            const preview = document.getElementById('previewKodeLengkap');
            const title = document.getElementById('modalVarianLabel');

            function getKodeBarang() {
                const selected = idbarang.options[idbarang.selectedIndex];
                return selected ? selected.getAttribute('data-kode') || '' : '';
            }

            function updatePreview() {
                const base = getKodeBarang();
                const suffix = kodevarian.value.trim();
                if (!base) {
                    preview.textContent = suffix || '-';
                    return;
                }
                preview.textContent = suffix ? base + '.' + suffix : base;
            }

            idbarang.addEventListener('change', updatePreview);
            kodevarian.addEventListener('input', updatePreview);

            document.getElementById('btnTambahVarian').addEventListener('click', function() {
                form.action = @json(route('barang-varian.store'));
                methodField.innerHTML = '';
                idbarang.value = '';
                kodevarian.value = '';
                namavarian.value = '';
                preview.textContent = '-';
                title.textContent = 'Tambah varian';
            });

            document.querySelectorAll('.btn-edit-varian').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    form.action = @json(url('barang-varian')) + '/' + this.dataset.id;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    idbarang.value = this.dataset.idbarang;
                    kodevarian.value = this.dataset.kodevarian;
                    namavarian.value = this.dataset.namavarian;
                    title.textContent = 'Ubah varian';
                    updatePreview();
                });
            });

            $('#dtBarangVarian').DataTable({
                order: [[0, 'desc']]
            });
        })();
    </script>
@endpush
