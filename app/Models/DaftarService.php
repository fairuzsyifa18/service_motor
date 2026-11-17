<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DaftarService extends Model
{
    protected $table = 'daftar_services';

    protected $primaryKey = 'id_daftar_service';

    protected $fillable = [
        'id_kendaraan',
        'id_pelanggan',
        'keluhan_kendaraan',
        'tanggal_service',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(
            Kendaraan::class,
            'id_kendaraan'
        );
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(
            Pelanggan::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }

    public function dataServices(): HasMany
    {
        return $this->hasMany(
            DataService::class,
            'id_daftar_service',
            'id_daftar_service'
        );
    }
}
