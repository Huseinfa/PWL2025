<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('penjualan_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('subtotal')->default(0); // Place subtotal right after jumlah
            $table->timestamps();

            $table->foreign('penjualan_id')->references('penjualan_id')->on('t_penjualan');
            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
        });

        // Check if there are existing records and update subtotal
        if (DB::table('t_penjualan_detail')->count() > 0) {
            DB::table('t_penjualan_detail')
                ->update([
                    'subtotal' => DB::raw('harga * jumlah')
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penjualan_detail');
    }
};