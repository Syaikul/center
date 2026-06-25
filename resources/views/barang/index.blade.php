@extends('layouts.app')

@section('content')
    <style>
        .master-row { cursor: pointer; }
        .master-row:hover { background-color: rgba(0, 0, 0, 0.04) !important; }
        .master-row.table-active { --bs-table-bg-state: var(--bs-primary-bg-subtle); }
        .level-badge {
            font-size: 0.7rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
    </style>

    @php
        $level = $selectedSubBarang ? 'varian' : ($selectedBarang ? 'sub' : 'barang');
    @endphp

    <div class="d-flex align-items-center flex-wrap gap-2 pt-2 pb-3">
        <h4 class="mb-0 me-auto">Barang</h4>
        @if ($level === 'barang')
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalBarang"
                id="btnTambahBarang">Tambah barang</button>
        @elseif ($level === 'sub')
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalSubBarang"
                id="btnTambahSubBarang">Tambah sub barang</button>
        @else
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalVarian"
                id="btnTambahVarian">Tambah varian</button>
        @endif
    </div>

    @include('partials.alert')

    {{-- Breadcrumb navigasi 3 level --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item {{ $level === 'barang' ? 'active' : '' }}">
                @if ($level === 'barang')
                    Barang
                @else
                    <a href="{{ route('barang.index') }}">Barang</a>
                @endif
            </li>
            @if ($selectedBarang)
                <li class="breadcrumb-item {{ $level === 'sub' ? 'active' : '' }}">
                    @if ($level === 'sub')
                        {{ $selectedBarang->namabarang }}
                    @else
                        <a href="{{ route('barang.index', ['barang' => $selectedBarang->idbarang]) }}">
                            {{ $selectedBarang->namabarang }}
                        </a>
                    @endif
                </li>
            @endif
            @if ($selectedSubBarang)
                <li class="breadcrumb-item active">{{ $selectedSubBarang->namasubbarang }}</li>
            @endif
        </ol>
    </nav>

    <div class="card">
        <div class="card-header d-flex align-items-center flex-wrap gap-2">
            @if ($level === 'barang')
                <span class="badge bg-primary level-badge">Level 1</span>
                <div class="card-title mb-0">Daftar barang</div>
            @elseif ($level === 'sub')
                <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <span class="badge bg-info level-badge">Level 2</span>
                <div class="card-title mb-0">
                    Sub barang: <strong>{{ $selectedBarang->namabarang }}</strong>
                    <small class="text-muted">({{ $selectedBarang->kodebarang }})</small>
                </div>
            @else
                <a href="{{ route('barang.index', ['barang' => $selectedBarang->idbarang]) }}"
                    class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <span class="badge bg-success level-badge">Level 3</span>
                <div class="card-title mb-0">
                    Varian: <strong>{{ $selectedSubBarang->namasubbarang }}</strong>
                    <small class="text-muted">(<code>{{ $selectedSubBarang->kode_lengkap }}</code>)</small>
                </div>
            @endif
        </div>
        <div class="card-body">
            @if ($level === 'barang')
                <div class="table-responsive">
                    <table id="dtBarang" class="display table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Detail tambahan</th>
                                <th class="text-center">Sub barang</th>
                                <th class="text-end" style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $row)
                                <tr class="master-row"
                                    data-href="{{ route('barang.index', ['barang' => $row->idbarang]) }}">
                                    <td><code>{{ $row->kodebarang }}</code></td>
                                    <td>{{ $row->namabarang }}</td>
                                    <td>{{ $row->tipe?->nama_tipe ?? '-' }}</td>
                                    <td class="text-muted small">
                                        @if ($row->detail_tambahan)
                                            {{ Str::limit($row->detail_tambahan, 50) }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary">{{ $row->sub_barang_count }}</span>
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-barang"
                                            data-id="{{ $row->idbarang }}" data-kode="{{ $row->kodebarang }}"
                                            data-nama="{{ $row->namabarang }}"
                                            data-detail="{{ e($row->detail_tambahan ?? '') }}"
                                            data-idtipe="{{ $row->idtipe }}"
                                            data-idsatuan="{{ $row->idsatuan }}" data-bs-toggle="modal"
                                            data-bs-target="#modalBarang" title="Ubah">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('barang.destroy', $row) }}" method="post"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus barang ini beserta sub barang dan variannya?');">
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
                <small class="text-muted d-block mt-2">Klik baris untuk mengelola sub barang.</small>

            @elseif ($level === 'sub')
                @if ($subBarangs->isEmpty())
                    <p class="text-muted mb-0">Belum ada sub barang. Tambahkan sub barang terlebih dahulu.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Kode lengkap</th>
                                    <th>Nama sub barang</th>
                                    <th class="text-center">Varian</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subBarangs as $sub)
                                    <tr class="master-row"
                                        data-href="{{ route('barang.index', ['barang' => $selectedBarang->idbarang, 'subbarang' => $sub->idsubbarang]) }}">
                                        <td><code>{{ $sub->kode_lengkap }}</code></td>
                                        <td>{{ $sub->nama_tampilan }}</td>
                                        <td class="text-center">
                                            @php $visibleVarian = $sub->visibleVarianCount(); @endphp
                                            @if ($visibleVarian === 0)
                                                <span class="badge bg-secondary">sub saja</span>
                                            @else
                                                <span class="badge badge-primary">{{ $visibleVarian }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end" onclick="event.stopPropagation();">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-sub"
                                                data-id="{{ $sub->idsubbarang }}"
                                                data-kode="{{ $sub->kodesubbarang }}"
                                                data-nama="{{ $sub->namasubbarang }}" data-bs-toggle="modal"
                                                data-bs-target="#modalSubBarang">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <form
                                                action="{{ route('barang.sub.destroy', [$selectedBarang, $sub]) }}"
                                                method="post" class="d-inline"
                                                onsubmit="return confirm('Hapus sub barang ini beserta variannya?');">
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
                    <small class="text-muted d-block mt-2">
                        Klik baris untuk mengelola varian. Badge <span class="badge bg-secondary">sub saja</span>
                        berarti item hanya sampai sub barang (tanpa varian tambahan).
                    </small>
                @endif

            @else
                @if ($varians->isEmpty())
                    <p class="text-muted mb-0">
                        Belum ada varian tambahan. Kode final
                        <code>{{ $selectedSubBarang->kode_lengkap }}</code>
                        dan nama tampilan
                        <strong>{{ $selectedSubBarang->nama_tampilan }}</strong>
                        mengikuti sub barang.
                        Klik <strong>Tambah varian</strong> jika item ini perlu level varian.
                    </p>
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
                                        <td>{{ $varian->nama_tampilan }}</td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-varian"
                                                data-id="{{ $varian->idvarian }}"
                                                data-kode="{{ $varian->kodevarian }}"
                                                data-nama="{{ $varian->namavarian }}" data-bs-toggle="modal"
                                                data-bs-target="#modalVarian">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <form
                                                action="{{ route('barang.varian.destroy', [$selectedBarang, $selectedSubBarang, $varian]) }}"
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
            @endif
        </div>
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
                            <label for="idtipe">Tipe</label>
                            <select class="form-select" id="idtipe" name="idtipe" required>
                                <option value="">- pilih tipe -</option>
                                @foreach ($tipes as $tipe)
                                    <option value="{{ $tipe->idtipe }}">{{ $tipe->nama_tipe }}</option>
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
        {{-- Modal sub barang --}}
        <div class="modal fade" id="modalSubBarang" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formSubBarang" method="post"
                        action="{{ route('barang.sub.store', $selectedBarang) }}">
                        @csrf
                        <div id="subMethodField"></div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSubBarangLabel">Tambah sub barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kodesubbarang">Kode sub barang</label>
                                <input type="text" class="form-control" id="kodesubbarang" name="kodesubbarang"
                                    placeholder="contoh: 2.0" required>
                                <small class="text-muted">Kode lengkap:
                                    <code id="previewKodeSub">{{ $selectedBarang->kodebarang }}.</code><span
                                        id="previewSubSuffix">...</span>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="namasubbarang">Nama sub barang</label>
                                <input type="text" class="form-control" id="namasubbarang" name="namasubbarang"
                                    required>
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

    @if ($selectedSubBarang)
        {{-- Modal varian --}}
        <div class="modal fade" id="modalVarian" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formVarian" method="post"
                        action="{{ route('barang.varian.store', [$selectedBarang, $selectedSubBarang]) }}">
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
                                    <code id="previewKodeLengkap">{{ $selectedSubBarang->kode_lengkap }}.</code><span
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
                const btnTambah = document.getElementById('btnTambahBarang');
                if (btnTambah) {
                    btnTambah.addEventListener('click', function() {
                        formBarang.action = @json(route('barang.store'));
                        methodField.innerHTML = '';
                        ['kodebarang', 'namabarang'].forEach(id => document.getElementById(id).value = '');
                        document.getElementById('detail_tambahan').value = '';
                        document.getElementById('idtipe').value = '';
                        document.getElementById('idsatuan').value = '';
                        title.textContent = 'Tambah barang';
                    });
                }
                document.querySelectorAll('.btn-edit-barang').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        formBarang.action = @json(url('barang')) + '/' + this.dataset.id;
                        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        document.getElementById('kodebarang').value = this.dataset.kode;
                        document.getElementById('namabarang').value = this.dataset.nama;
                        document.getElementById('detail_tambahan').value = this.dataset.detail || '';
                        document.getElementById('idtipe').value = this.dataset.idtipe;
                        document.getElementById('idsatuan').value = this.dataset.idsatuan;
                        title.textContent = 'Ubah barang';
                    });
                });
            }

            @if ($selectedBarang)
                const kodeBarang = @json($selectedBarang->kodebarang);
                const formSub = document.getElementById('formSubBarang');
                const subMethod = document.getElementById('subMethodField');
                const kodesubbarang = document.getElementById('kodesubbarang');
                const namasubbarang = document.getElementById('namasubbarang');
                const previewSubSuffix = document.getElementById('previewSubSuffix');
                const subTitle = document.getElementById('modalSubBarangLabel');
                const subStoreUrl = @json(route('barang.sub.store', $selectedBarang));

                if (kodesubbarang) {
                    kodesubbarang.addEventListener('input', function() {
                        previewSubSuffix.textContent = this.value.trim() || '...';
                    });
                }

                const btnTambahSub = document.getElementById('btnTambahSubBarang');
                if (btnTambahSub) {
                    btnTambahSub.addEventListener('click', function() {
                        formSub.action = subStoreUrl;
                        subMethod.innerHTML = '';
                        kodesubbarang.value = '';
                        namasubbarang.value = '';
                        previewSubSuffix.textContent = '...';
                        subTitle.textContent = 'Tambah sub barang — {{ $selectedBarang->namabarang }}';
                    });
                }

                document.querySelectorAll('.btn-edit-sub').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        formSub.action = @json(url('barang/'.$selectedBarang->idbarang.'/sub-barang')) + '/' + this.dataset.id;
                        subMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        kodesubbarang.value = this.dataset.kode;
                        namasubbarang.value = this.dataset.nama;
                        previewSubSuffix.textContent = this.dataset.kode;
                        subTitle.textContent = 'Ubah sub barang';
                    });
                });
            @endif

            @if ($selectedSubBarang)
                const formVarian = document.getElementById('formVarian');
                const varianMethod = document.getElementById('varianMethodField');
                const kodevarian = document.getElementById('kodevarian');
                const namavarian = document.getElementById('namavarian');
                const previewSuffix = document.getElementById('previewSuffix');
                const varianTitle = document.getElementById('modalVarianLabel');
                const varianStoreUrl = @json(route('barang.varian.store', [$selectedBarang, $selectedSubBarang]));
                const kodeSubLengkap = @json($selectedSubBarang->kode_lengkap);

                kodevarian.addEventListener('input', function() {
                    previewSuffix.textContent = this.value.trim() || '...';
                });

                const btnTambahVarian = document.getElementById('btnTambahVarian');
                if (btnTambahVarian) {
                    btnTambahVarian.addEventListener('click', function() {
                        formVarian.action = varianStoreUrl;
                        varianMethod.innerHTML = '';
                        kodevarian.value = '';
                        namavarian.value = '';
                        previewSuffix.textContent = '...';
                        varianTitle.textContent = 'Tambah varian — {{ $selectedSubBarang->namasubbarang }}';
                    });
                }

                document.querySelectorAll('.btn-edit-varian').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        formVarian.action = @json(url('barang/'.$selectedBarang->idbarang.'/sub-barang/'.$selectedSubBarang->idsubbarang.'/varian')) + '/' + this.dataset.id;
                        varianMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        kodevarian.value = this.dataset.kode;
                        namavarian.value = this.dataset.nama;
                        previewSuffix.textContent = this.dataset.kode;
                        varianTitle.textContent = 'Ubah varian';
                    });
                });
            @endif

            @if ($level === 'barang')
                $('#dtBarang').DataTable({
                    paging: true,
                    searching: true,
                    order: [[1, 'asc']],
                    columnDefs: [{ orderable: false, targets: 5 }]
                });
            @endif
        })();
    </script>
@endpush
