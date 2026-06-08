@extends('layouts.app')

@section('content')
    <style>
        .master-row { cursor: pointer; }
        .master-row:hover { background-color: rgba(0, 0, 0, 0.04) !important; }
        .master-row.table-active { --bs-table-bg-state: var(--bs-primary-bg-subtle); }
        .detail-panel { border-left: 4px solid var(--bs-primary); }
    </style>

    <div class="d-flex align-items-center flex-wrap gap-2 pt-2 pb-3">
        <h4 class="mb-0 me-auto">Barang</h4>
        <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalBarang"
            id="btnTambahBarang">Tambah barang</button>
    </div>

    @include('partials.alert')

    <div class="row g-4">
        <div class="col-lg-{{ $selectedBarang ? '7' : '12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">Daftar barang</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtBarang" class="display table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Detail tambahan</th>
                                    <th class="text-center">Jumlah varian</th>
                                    <th class="text-end" style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $row)
                                    <tr class="master-row {{ $selectedBarang?->idbarang === $row->idbarang ? 'table-active' : '' }}"
                                        data-href="{{ route('barang.index', ['barang' => $row->idbarang]) }}">
                                        <td>{{ $row->namabarang }}</td>
                                        <td>{{ $row->kategori?->nama_kategori ?? '-' }}</td>
                                        <td class="text-muted small">
                                            @if ($row->detail_tambahan)
                                                {{ Str::limit($row->detail_tambahan, 60) }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $row->varian_count }}</span>
                                        </td>
                                        <td class="text-end" onclick="event.stopPropagation();">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-barang"
                                                data-id="{{ $row->idbarang }}" data-kode="{{ $row->kodebarang }}"
                                                data-nama="{{ $row->namabarang }}"
                                                data-detail="{{ e($row->detail_tambahan ?? '') }}"
                                                data-idkategori="{{ $row->idkategori }}"
                                                data-idsatuan="{{ $row->idsatuan }}" data-bs-toggle="modal"
                                                data-bs-target="#modalBarang" title="Ubah">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <form action="{{ route('barang.destroy', $row) }}" method="post"
                                                class="d-inline"
                                                onsubmit="return confirm('Hapus barang ini beserta variannya?');">
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
                    <small class="text-muted d-block mt-2">Klik baris untuk melihat dan mengelola varian.</small>
                </div>
            </div>
        </div>

        @if ($selectedBarang)
            <div class="col-lg-5">
                <div class="card detail-panel">
                    <div class="card-header d-flex align-items-center flex-wrap gap-2">
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary"
                            title="Kembali ke daftar barang">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <div class="card-title mb-0">
                            Varian: <strong>{{ $selectedBarang->namabarang }}</strong>
                            <small class="text-muted">({{ $selectedBarang->kodebarang }})</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#modalVarian" id="btnTambahVarian">Tambah varian</button>
                    </div>
                    <div class="card-body">
                        @if ($varians->isEmpty())
                            <p class="text-muted mb-0">Belum ada varian untuk barang ini.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Kode lengkap</th>
                                            <th>Nama varian</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($varians as $varian)
                                            <tr>
                                                <td><code>{{ $varian->kode_lengkap }}</code></td>
                                                <td>{{ $varian->namavarian }}</td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-warning btn-edit-varian"
                                                        data-id="{{ $varian->idvarian }}"
                                                        data-kode="{{ $varian->kodevarian }}"
                                                        data-nama="{{ $varian->namavarian }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalVarian">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <form
                                                        action="{{ route('barang.varian.destroy', [$selectedBarang, $varian]) }}"
                                                        method="post" class="d-inline"
                                                        onsubmit="return confirm('Hapus varian ini?');">
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

    {{-- Modal barang --}}
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
                        <div class="form-group">
                            <label for="detail_tambahan">Detail tambahan <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea class="form-control" id="detail_tambahan" name="detail_tambahan" rows="3"
                                placeholder="Catatan tambahan tentang barang"></textarea>
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

    @if ($selectedBarang)
        <div class="modal fade" id="modalVarian" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formVarian" method="post"
                        action="{{ route('barang.varian.store', $selectedBarang) }}">
                        @csrf
                        <div id="varianMethodField"></div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalVarianLabel">Tambah varian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kodevarian">Kode varian</label>
                                <input type="text" class="form-control" id="kodevarian" name="kodevarian"
                                    placeholder="contoh: 9.0" required>
                                <small class="text-muted">Kode lengkap:
                                    <code id="previewKodeLengkap">{{ $selectedBarang->kodebarang }}.</code><span
                                        id="previewSuffix">...</span>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="namavarian">Nama varian</label>
                                <input type="text" class="form-control" id="namavarian" name="namavarian"
                                    placeholder="contoh: ukuran XL" required>
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

            const formBarang = document.getElementById('formBarang');
            if (formBarang) {
                const methodField = document.getElementById('barangMethodField');
                const title = document.getElementById('modalBarangLabel');
                document.getElementById('btnTambahBarang').addEventListener('click', function() {
                    formBarang.action = @json(route('barang.store'));
                    methodField.innerHTML = '';
                    ['kodebarang', 'namabarang'].forEach(id => document.getElementById(id).value = '');
                    document.getElementById('detail_tambahan').value = '';
                    document.getElementById('idkategori').value = '';
                    document.getElementById('idsatuan').value = '';
                    title.textContent = 'Tambah barang';
                });
                document.querySelectorAll('.btn-edit-barang').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        formBarang.action = @json(url('barang')) + '/' + this.dataset.id;
                        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        document.getElementById('kodebarang').value = this.dataset.kode;
                        document.getElementById('namabarang').value = this.dataset.nama;
                        document.getElementById('detail_tambahan').value = this.dataset.detail || '';
                        document.getElementById('idkategori').value = this.dataset.idkategori;
                        document.getElementById('idsatuan').value = this.dataset.idsatuan;
                        title.textContent = 'Ubah barang';
                    });
                });
            }

            @if ($selectedBarang)
                const kodeBarang = @json($selectedBarang->kodebarang);
                const formVarian = document.getElementById('formVarian');
                const varianMethod = document.getElementById('varianMethodField');
                const kodevarian = document.getElementById('kodevarian');
                const namavarian = document.getElementById('namavarian');
                const previewSuffix = document.getElementById('previewSuffix');
                const varianTitle = document.getElementById('modalVarianLabel');
                const storeUrl = @json(route('barang.varian.store', $selectedBarang));

                kodevarian.addEventListener('input', function() {
                    previewSuffix.textContent = this.value.trim() || '...';
                });

                document.getElementById('btnTambahVarian').addEventListener('click', function() {
                    formVarian.action = storeUrl;
                    varianMethod.innerHTML = '';
                    kodevarian.value = '';
                    namavarian.value = '';
                    previewSuffix.textContent = '...';
                    varianTitle.textContent = 'Tambah varian — {{ $selectedBarang->namabarang }}';
                });

                document.querySelectorAll('.btn-edit-varian').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        formVarian.action = @json(url('barang/'.$selectedBarang->idbarang.'/varian')) + '/' + this.dataset.id;
                        varianMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        kodevarian.value = this.dataset.kode;
                        namavarian.value = this.dataset.nama;
                        previewSuffix.textContent = this.dataset.kode;
                        varianTitle.textContent = 'Ubah varian';
                    });
                });
            @endif

            $('#dtBarang').DataTable({
                paging: true,
                searching: true,
                order: [[0, 'asc']],
                columnDefs: [{ orderable: false, targets: 4 }]
            });
        })();
    </script>
@endpush
