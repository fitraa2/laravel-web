<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kemampuan_1104', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biodata_id')->constrained('biodata_1104')->cascadeOnDelete();
            $table->string('nama_kemampuan', 150);
            $table->string('jenis', 20)->default('teknis'); // teknis | non_teknis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kemampuan_1104');
    }
};
