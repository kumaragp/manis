<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->integer('jumlah_alat')->default(0);
            $table->string('gambar')->nullable(); // bukti kerusakan / upload gambar
            $table->enum('status', [
                'tersedia',
                'sedang_digunakan',
                'dalam_perawatan',
                'rusak'
            ])->default('tersedia');

            // timestamps fungsional, bukan asosiasi logika yg membingungkan
            $table->timestamps(); // created_at = pembelian/pencatatan awal, updated_at = perubahan status

            // atribut tambahan
            $table->bigInteger('harga')->nullable();
            $table->string('vendor')->nullable();
            $table->string('tujuan')->nullable(); // peruntukan / divisi yg pakai

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool');
    }
};
