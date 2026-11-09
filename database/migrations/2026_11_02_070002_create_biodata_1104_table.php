<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biodata_1104', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('posisi', 100)->nullable();
            $table->string('email', 100);
            $table->string('telepon', 30);
            $table->string('alamat', 255);
            $table->text('tentang_saya');
            $table->string('foto')->nullable();                 // nama file foto
            $table->boolean('tampilkan_foto')->default(true);   // include / exclude foto di CV
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodata_1104');
    }
};
