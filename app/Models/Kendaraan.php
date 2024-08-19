<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'merek_id',
        'tipe_id',
        'no_plat',
        'foto',
        'keterangan',
        'maintenance_schedule_months',
        'last_maintenance_date',
        'reminder_sent',
        'reminder_sent_at',
    ];

    protected $dates = [
        'last_maintenance_date',
        'reminder_sent_at',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function perbaikans()
    {
        return $this->hasMany(Perbaikan::class);
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function tipe()
    {
        return $this->belongsTo(Tipe::class);
    }
}
