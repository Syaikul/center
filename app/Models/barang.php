<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class barang extends Model
{
    protected $table = 'barang';

    protected $primaryKey = 'idbarang';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'kodebarang',
        'namabarang',
        'idkategori',
        'idsatuan',
        'detail_tambahan',
    ];

    public function getRouteKeyName(): string
    {
        return 'idbarang';
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(kategori::class, 'idkategori', 'idkategori');
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(satuan::class, 'idsatuan', 'idsatuan');
    }

    public function subBarang(): HasMany
    {
        return $this->hasMany(barang_sub::class, 'idbarang', 'idbarang');
    }

    public function varian(): HasManyThrough
    {
        return $this->hasManyThrough(
            barang_varian::class,
            barang_sub::class,
            'idbarang',
            'idsubbarang',
            'idbarang',
            'idsubbarang'
        );
    }
}
