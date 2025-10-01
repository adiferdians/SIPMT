<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('risalahs', function (Blueprint $table) {
            $table->id();
            $table->string('unit_kerja');
            $table->string('tgl');
            $table->string('jam');
            $table->string('tempat');
            $table->string('perekam_1');
            $table->string('perekam_2')->nullable();
            $table->string('transkrip')->nullable();
            $table->string('editor')->nullable();
            $table->string('rapat');
            $table->text('agenda');
            $table->string('status')->default('Belum Terlaksana')->nullable();
            $table->string('masa_sidang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risalahs');
    }
};
