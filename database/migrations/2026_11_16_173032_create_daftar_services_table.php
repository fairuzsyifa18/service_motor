<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_services', function (Blueprint $table) {
            $table->id('id_daftar_service');

            $table->foreignId('id_kendaraan')
                ->constrained('kendaraans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_pelanggan')
                ->constrained('pelanggans', 'id_pelanggan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('keluhan_kendaraan');
            $table->date('tanggal_service');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_services');
    }
};
