<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class posisi extends Model
{
    protected $table = 'posisi';

    protected $primaryKey = 'idposisi';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'namaposisi',
    ];

    public function getRouteKeyName(): string
    {
        return 'idposisi';
    }
}
