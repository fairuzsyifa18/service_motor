<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranService extends Model
{
    protected $table = 'pembayaran_services';

    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_data_service',
        'jumlah_biaya_servis',
        'jenis_pembayaran',
        'keterangan',
    ];

    public function dataService(): BelongsTo
    {
        return $this->belongsTo(
            DataService::class,
            'id_data_service',
            'id_data_service'
        );
    }
}
