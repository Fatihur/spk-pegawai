<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->string('periode');
            $table->decimal('nilai_mfep', 10, 4)->nullable();
            $table->integer('ranking_mfep')->nullable();
            $table->timestamps();
            
            $table->unique(['pegawai_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil');
    }
};
