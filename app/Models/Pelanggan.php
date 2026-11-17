<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'nama_lengkap',
        'no_hp',
        'alamat_pelanggan',
        'pekerjaan',
    ];

    // Satu pelanggan dapat memiliki banyak riwayat service
    public function daftarServices(): HasMany
    {
        return $this->hasMany(
            DaftarService::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }
}
