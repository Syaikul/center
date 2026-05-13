<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $table = 'kategori';

    protected $primaryKey = 'idkategori';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama_kategori',
    ];

    public function getRouteKeyName(): string
    {
        return 'idkategori';
    }
}
