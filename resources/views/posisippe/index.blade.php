<!-- @extends('layouts.app') -->

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="ms-md-auto py-2 py-md-0">
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalPosisippe"
                id="btnTambahPosisippe">Tambah mapping posisi-PPE</button>
        </div>
    </div>

    @include('partials.alert')

    <div class="card">
        <div class="card-header"><div class="card-title">Posisi ke PPE</div></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dtPosisippe" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Posisi</th>
                            <th>Barang PPE</th>
                            <th>Qty</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posisippes as $row)
                            <tr>
                                <td>{{ $row->idposppe }}</td>
                                <td>{{ $row->posisi?->namaposisi }}</td>
                                <td>{{ $row->barang?->namabarang }}</td>
                                <td>{{ $row->qty }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-posisippe"
                                        data-id="{{ $row->idposppe }}" data-idposisi="{{ $row->idposisi }}"
                                        data-idbarang="{{ $row->idbarang }}" data-qty="{{ $row->qty }}"
                                        data-bs-toggle="modal" data-bs-target="#modalPosisippe">Ubah</button>
                                    <form action="{{ route('posisippe.destroy', $row) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus mapping ini?');">
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

    <div class="modal fade" id="modalPosisippe" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <form id="formPosisippe" method="post" action="{{ route('posisippe.store') }}">
                @csrf
                <div id="posisippeMethodField"></div>
                <div class="modal-header"><h5 class="modal-title" id="modalPosisippeLabel">Tambah mapping posisi-PPE</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idposisi">Posisi</label>
                        <select class="form-select" id="idposisi" name="idposisi" required>
                            <option value="">- pilih posisi -</option>
                            @foreach ($posisis as $posisi)
                                <option value="{{ $posisi->idposisi }}">{{ $posisi->namaposisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idbarang">Barang PPE</label>
                        <select class="form-select" id="idbarang" name="idbarang" required>
                            <option value="">- pilih barang -</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->idbarang }}">{{ $barang->namabarang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" min="1" class="form-control" id="qty" name="qty" required>
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
            const form = document.getElementById('formPosisippe');
            const methodField = document.getElementById('posisippeMethodField');
            const idposisi = document.getElementById('idposisi');
            const idbarang = document.getElementById('idbarang');
            const qty = document.getElementById('qty');
            const title = document.getElementById('modalPosisippeLabel');
            document.getElementById('btnTambahPosisippe').addEventListener('click', function() {
                form.action = @json(route('posisippe.store'));
                methodField.innerHTML = '';
                idposisi.value = '';
                idbarang.value = '';
                qty.value = '';
                title.textContent = 'Tambah mapping posisi-PPE';
            });
            document.querySelectorAll('.btn-edit-posisippe').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    form.action = @json(url('posisippe')) + '/' + this.dataset.id;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    idposisi.value = this.dataset.idposisi;
                    idbarang.value = this.dataset.idbarang;
                    qty.value = this.dataset.qty;
                    title.textContent = 'Ubah mapping posisi-PPE';
                });
            });
            $('#dtPosisippe').DataTable();
        })();
    </script>
@endpush
