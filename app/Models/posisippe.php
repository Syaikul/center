<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class posisippe extends Model
{
    protected $table = 'posisippe';

    protected $primaryKey = 'idposppe';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'idposisi',
        'idbarang',
        'qty',
    ];

    public function getRouteKeyName(): string
    {
        return 'idposppe';
    }

    public function posisi(): BelongsTo
    {
        return $this->belongsTo(posisi::class, 'idposisi', 'idposisi');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(barang::class, 'idbarang', 'idbarang');
    }
}
