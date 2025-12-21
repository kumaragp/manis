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
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->constrained('alat')->onDelete('cascade');
            $table->string('nama_alat');
            $table->date('tanggal_pengadaan');
            $table->string('vendor')->nullable();
            $table->integer('jumlah');
            $table->bigInteger('harga')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan');
    }
};
