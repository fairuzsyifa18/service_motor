<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_services', function (Blueprint $table) {
            $table->id('id_data_service');

            $table->foreignId('id_daftar_service')
                ->constrained('daftar_services', 'id_daftar_service')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('estimasi_service');
            $table->string('nama_mekanik');
            $table->text('sparepart_pengganti');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_services');
    }
};
