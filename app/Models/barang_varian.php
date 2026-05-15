<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class barang_varian extends Model
{
    protected $table = 'barang_varian';

    protected $primaryKey = 'idvarian';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'idbarang',
        'kodevarian',
        'namavarian',
    ];

    protected $appends = [
        'kode_lengkap',
    ];

    public function getRouteKeyName(): string
    {
        return 'idvarian';
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(barang::class, 'idbarang', 'idbarang');
    }

    /**
     * Kode lengkap: kodebarang + kodevarian (contoh: 1.1.1 + 9.0 => 1.1.1.9.0)
     */
    public function getKodeLengkapAttribute(): string
    {
        $kodeBarang = $this->barang?->kodebarang ?? '';

        if ($kodeBarang === '' || $this->kodevarian === null || $this->kodevarian === '') {
            return $kodeBarang;
        }

        return $kodeBarang.'.'.$this->kodevarian;
    }
}
