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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            // Foreign key dengan onDelete cascade
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Data utama laporan
            $table->string('judul');
            $table->string('pemasukan')->default('Rp');
            $table->string('pengeluaran')->default('Rp');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->date('tanggal');

            // File upload - nullable sesuai kebutuhan
            $table->string('gambar')->nullable();

            // Status dengan nilai yang konsisten
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');

            // Response dari admin - nullable
            $table->text('respon')->nullable();

            // Timestamps
            $table->timestamps();

            // Index untuk performa
            $table->index(['user_id', 'status']); // Index gabungan untuk query user dan status
            $table->index('tanggal'); // Index untuk query berdasarkan tanggal
            $table->index('created_at'); // Index untuk sorting berdasarkan waktu buat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
