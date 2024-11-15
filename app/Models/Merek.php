<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_merek',
    ];

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
