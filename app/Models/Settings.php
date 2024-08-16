<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_nama',
        'deskripsi',
        'alamat',
        'map_google',
        'jam_operasional',
        'telepon',
        'email',
        'facebook',
        'instagram',
        'whatsapp',
    ];

    public static function getValue($key, $default = null)
    {
        $setting = self::first();
        return $setting ? $setting->$key : $default;
    }
}
