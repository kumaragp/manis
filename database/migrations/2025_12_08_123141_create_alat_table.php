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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();

            $table->string('nama_alat')->unique();
            $table->integer('jumlah_alat')->default(0);
            $table->bigInteger('harga')->nullable();
            $table->enum('status', [
                'tersedia',
                'sedang_digunakan',
                'dalam_perawatan',
                'rusak'
                ])->default('tersedia');
                
           $table->string('gambar')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
