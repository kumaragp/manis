<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alat_id')->constrained('alat')->onDelete('cascade');
            $table->integer('jumlah');
            $table->bigInteger('harga_jual');
            $table->string('customer');
            $table->date('tanggal_penjualan');
            $table->string('gambar')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
