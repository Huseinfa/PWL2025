<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMBarangTable extends Migration
{
    public function up()
    {
        Schema::table('m_barang', function (Blueprint $table) {
            // Add stok column if it doesn't exist
            if (!Schema::hasColumn('m_barang', 'stok')) {
                $table->integer('stok')->default(0)->after('harga_jual');
            }
        });
    }

    public function down()
    {
        Schema::table('m_barang', function (Blueprint $table) {
            if (Schema::hasColumn('m_barang', 'stok')) {
                $table->dropColumn('stok');
            }
        });
    }
}