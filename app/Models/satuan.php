<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    protected $table = 'satuan';

    protected $primaryKey = 'idsatuan';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama_satuan',
    ];

    public function getRouteKeyName(): string
    {
        return 'idsatuan';
    }
}
