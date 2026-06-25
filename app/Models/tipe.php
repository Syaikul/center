<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipe extends Model
{
    protected $table = 'tipe';

    protected $primaryKey = 'idtipe';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama_tipe',
    ];

    public function getRouteKeyName(): string
    {
        return 'idtipe';
    }
}
