<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class barang_sub extends Model
{
    protected $table = 'barang_sub';

    protected $primaryKey = 'idsubbarang';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'idbarang',
        'kodesubbarang',
        'namasubbarang',
    ];

    protected $appends = [
        'kode_lengkap',
        'nama_tampilan',
    ];

    public function getRouteKeyName(): string
    {
        return 'idsubbarang';
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(barang::class, 'idbarang', 'idbarang');
    }

    public function varian(): HasMany
    {
        return $this->hasMany(barang_varian::class, 'idsubbarang', 'idsubbarang');
    }

    public function defaultVarian(): ?barang_varian
    {
        return $this->varian()
            ->where('namavarian', barang_varian::DEFAULT_NAMA)
            ->where(function ($query) {
                $query->whereNull('kodevarian')
                    ->orWhere('kodevarian', '');
            })
            ->first();
    }

    public function hasOnlyDefaultVarian(): bool
    {
        $count = $this->varian()->count();

        if ($count !== 1) {
            return false;
        }

        return (bool) $this->varian()->first()?->isDefault();
    }

    public function visibleVarianCount(): int
    {
        if ($this->hasOnlyDefaultVarian()) {
            return 0;
        }

        return $this->varian()->nonDefault()->count();
    }

    public function ensureDefaultVarian(): barang_varian
    {
        $default = $this->defaultVarian();

        if ($default) {
            return $default;
        }

        return $this->varian()->create(barang_varian::defaultPayload());
    }

    /**
     * Kode lengkap: kodebarang + kodesubbarang (contoh: 1 + 1.1 => 1.1.1)
     */
    public function getKodeLengkapAttribute(): string
    {
        $kodeBarang = $this->barang?->kodebarang ?? '';

        if ($kodeBarang === '' || $this->kodesubbarang === null || $this->kodesubbarang === '') {
            return $kodeBarang;
        }

        return $kodeBarang.'.'.$this->kodesubbarang;
    }

    /**
     * Nama tampilan mengacu ke varian utama (default = nama sub barang).
     */
    public function getNamaTampilanAttribute(): string
    {
        return $this->defaultVarian()?->nama_tampilan ?? $this->namasubbarang;
    }
}
