<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class personel extends Model
{
    protected $table = 'personel';

    protected $primaryKey = 'idpersonel';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nik',
        'namapersonel',
    ];

    public function getRouteKeyName(): string
    {
        return 'idpersonel';
    }
}
