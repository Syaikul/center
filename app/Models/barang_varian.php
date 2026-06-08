<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class barang_varian extends Model
{
    public const DEFAULT_NAMA = '-';

    protected $table = 'barang_varian';

    protected $primaryKey = 'idvarian';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'idsubbarang',
        'kodevarian',
        'namavarian',
    ];

    protected $appends = [
        'kode_lengkap',
        'nama_tampilan',
        'is_default',
    ];

    public function getRouteKeyName(): string
    {
        return 'idvarian';
    }

    public function subBarang(): BelongsTo
    {
        return $this->belongsTo(barang_sub::class, 'idsubbarang', 'idsubbarang');
    }

    public function isDefault(): bool
    {
        return $this->namavarian === self::DEFAULT_NAMA
            && ($this->kodevarian === null || $this->kodevarian === '');
    }

    public function getIsDefaultAttribute(): bool
    {
        return $this->isDefault();
    }

    /**
     * Nama tampilan: default memakai nama sub barang, selain itu nama varian.
     */
    public function getNamaTampilanAttribute(): string
    {
        if ($this->isDefault()) {
            return $this->subBarang?->namasubbarang ?? self::DEFAULT_NAMA;
        }

        return $this->namavarian;
    }

    /**
     * Kode lengkap: tanpa kode varian berarti final kode = kode sub barang.
     */
    public function getKodeLengkapAttribute(): string
    {
        $kodeSub = $this->subBarang?->kode_lengkap ?? '';

        if ($kodeSub === '' || $this->kodevarian === null || $this->kodevarian === '') {
            return $kodeSub;
        }

        return $kodeSub.'.'.$this->kodevarian;
    }

    public function scopeNonDefault(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('namavarian', '!=', self::DEFAULT_NAMA)
                ->orWhere(function (Builder $q2) {
                    $q2->whereNotNull('kodevarian')
                        ->where('kodevarian', '!=', '');
                });
        });
    }

    public static function defaultPayload(): array
    {
        return [
            'namavarian' => self::DEFAULT_NAMA,
            'kodevarian' => null,
        ];
    }
}
