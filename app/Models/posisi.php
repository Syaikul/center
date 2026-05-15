<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function items(): HasMany
    {
        return $this->hasMany(posisippe::class, 'idposisi', 'idposisi');
    }
}
