<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->integer('nilai');
            $table->string('periode');
            $table->timestamps();
            
            $table->unique(['pegawai_id', 'kriteria_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
