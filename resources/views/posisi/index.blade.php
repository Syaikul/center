@extends('layouts.app')

@section('content')
    <style>
        .master-row { cursor: pointer; }
        .master-row:hover { background-color: rgba(0, 0, 0, 0.04) !important; }
        .master-row.table-active { --bs-table-bg-state: var(--bs-primary-bg-subtle); }
        .detail-panel { border-left: 4px solid var(--bs-primary); }
    </style>

    <div class="d-flex align-items-center flex-wrap gap-2 pt-2 pb-3">
        <h4 class="mb-0 me-auto">Posisi</h4>
        <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalPosisi"
            id="btnTambahPosisi">Tambah posisi</button>
    </div>

    @include('partials.alert')

    <div class="row g-4">
        <div class="col-lg-{{ $selectedPosisi ? '7' : '12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">Daftar posisi</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtPosisi" class="display table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama posisi</th>
                                    <th class="text-center">Jumlah item</th>
                                    <th class="text-end" style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posisis as $row)
                                    <tr class="master-row {{ $selectedPosisi?->idposisi === $row->idposisi ? 'table-active' : '' }}"
                                        data-href="{{ route('posisi.index', ['posisi' => $row->idposisi]) }}">
                                        <td>{{ $row->namaposisi }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $row->items_count }}</span>
                                        </td>
                                        <td class="text-end" onclick="event.stopPropagation();">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-posisi"
                                                data-id="{{ $row->idposisi }}" data-nama="{{ $row->namaposisi }}"
                                                data-bs-toggle="modal" data-bs-target="#modalPosisi" title="Ubah">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <form action="{{ route('posisi.destroy', $row) }}" method="post"
                                                class="d-inline" onsubmit="return confirm('Hapus posisi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <small class="text-muted d-block mt-2">Klik baris untuk melihat dan mengelola item PPE.</small>
                </div>
            </div>
        </div>

        @if ($selectedPosisi)
            <div class="col-lg-5">
                <div class="card detail-panel">
                    <div class="card-header d-flex align-items-center flex-wrap gap-2">
                        <div class="card-title mb-0">
                            Item PPE: <strong>{{ $selectedPosisi->namaposisi }}</strong>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#modalItem" id="btnTambahItem">Tambah item</button>
                    </div>
                    <div class="card-body">
                        @if ($items->isEmpty())
                            <p class="text-muted mb-0">Belum ada sub barang terkait untuk posisi ini.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sub barang</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->subBarang?->nama_tampilan }}
                                                    <small class="text-muted d-block">
                                                        <code>{{ $item->subBarang?->kode_lengkap }}</code>
                                                        — {{ $item->subBarang?->barang?->namabarang }}
                                                    </small>
                                                </td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-warning btn-edit-item"
                                                        data-id="{{ $item->idposppe }}"
                                                        data-idsubbarang="{{ $item->idsubbarang }}"
                                                        data-qty="{{ $item->qty }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalItem">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <form
                                                        action="{{ route('posisi.item.destroy', [$selectedPosisi, $item]) }}"
                                                        method="post" class="d-inline"
                                                        onsubmit="return confirm('Hapus item ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="modalPosisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formPosisi" method="post" action="{{ route('posisi.store') }}">
                    @csrf
                    <div id="posisiMethodField"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPosisiLabel">Tambah posisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaposisi">Nama posisi</label>
                            <input type="text" class="form-control" id="namaposisi" name="namaposisi" required>
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

    @if ($selectedPosisi)
        <div class="modal fade" id="modalItem" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formItem" method="post" action="{{ route('posisi.item.store', $selectedPosisi) }}">
                        @csrf
                        <div id="itemMethodField"></div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalItemLabel">Tambah item — {{ $selectedPosisi->namaposisi }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="idsubbarang">Sub barang</label>
                                <select class="form-select" id="idsubbarang" name="idsubbarang" required>
                                    <option value="">- pilih sub barang -</option>
                                    @foreach ($subBarangs as $sub)
                                        <option value="{{ $sub->idsubbarang }}">
                                            {{ $sub->nama_tampilan }} ({{ $sub->kode_lengkap }}) — {{ $sub->barang?->namabarang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" min="1" class="form-control" id="qty" name="qty" required>
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
    @endif
@endsection

@push('scripts')
    <script>
        (function() {
            document.querySelectorAll('.master-row[data-href]').forEach(function(row) {
                row.addEventListener('click', function(e) {
                    if (e.target.closest('button, form, a')) return;
                    window.location = this.dataset.href;
                });
            });

            const formPosisi = document.getElementById('formPosisi');
            const posisiMethod = document.getElementById('posisiMethodField');
            const namaposisi = document.getElementById('namaposisi');
            const posisiTitle = document.getElementById('modalPosisiLabel');

            document.getElementById('btnTambahPosisi').addEventListener('click', function() {
                formPosisi.action = @json(route('posisi.store'));
                posisiMethod.innerHTML = '';
                namaposisi.value = '';
                posisiTitle.textContent = 'Tambah posisi';
            });

            document.querySelectorAll('.btn-edit-posisi').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    formPosisi.action = @json(url('posisi')) + '/' + this.dataset.id;
                    posisiMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    namaposisi.value = this.dataset.nama;
                    posisiTitle.textContent = 'Ubah posisi';
                });
            });

            @if ($selectedPosisi)
                const formItem = document.getElementById('formItem');
                const itemMethod = document.getElementById('itemMethodField');
                const idsubbarang = document.getElementById('idsubbarang');
                const qty = document.getElementById('qty');
                const itemTitle = document.getElementById('modalItemLabel');
                const storeItemUrl = @json(route('posisi.item.store', $selectedPosisi));

                document.getElementById('btnTambahItem').addEventListener('click', function() {
                    formItem.action = storeItemUrl;
                    itemMethod.innerHTML = '';
                    idsubbarang.value = '';
                    qty.value = '';
                    itemTitle.textContent = 'Tambah item — {{ $selectedPosisi->namaposisi }}';
                });

                document.querySelectorAll('.btn-edit-item').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        formItem.action = @json(url('posisi/'.$selectedPosisi->idposisi.'/item')) + '/' + this.dataset.id;
                        itemMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        idsubbarang.value = this.dataset.idsubbarang;
                        qty.value = this.dataset.qty;
                        itemTitle.textContent = 'Ubah item';
                    });
                });
            @endif

            $('#dtPosisi').DataTable({
                paging: true,
                searching: true,
                order: [[0, 'asc']],
                columnDefs: [{ orderable: false, targets: 2 }]
            });
        })();
    </script>
@endpush
