<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{
    protected $table = 'gudang';

    protected $primaryKey = 'idgudang';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'namagudang',
        'nomorkontrak',
    ];

    public function getRouteKeyName(): string
    {
        return 'idgudang';
    }
}
