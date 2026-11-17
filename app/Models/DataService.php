<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataService extends Model
{
    protected $table = 'data_services';

    protected $primaryKey = 'id_data_service';

    protected $fillable = [
        'id_daftar_service',
        'estimasi_service',
        'nama_mekanik',
        'sparepart_pengganti',
    ];

    public function daftarService(): BelongsTo
    {
        return $this->belongsTo(
            DaftarService::class,
            'id_daftar_service',
            'id_daftar_service'
        );
    }

    public function pembayaranServices(): HasMany
    {
        return $this->hasMany(
            PembayaranService::class,
            'id_data_service',
            'id_data_service'
        );
    }
}
