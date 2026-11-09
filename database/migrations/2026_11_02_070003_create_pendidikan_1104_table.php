<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendidikan_1104', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biodata_id')->constrained('biodata_1104')->cascadeOnDelete();
            $table->string('institusi', 150);
            $table->string('jurusan', 150)->nullable();
            $table->string('tahun_mulai', 4);
            $table->string('tahun_selesai', 4)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendidikan_1104');
    }
};
