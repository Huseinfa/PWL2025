<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalHargaToTPenjualanTable extends Migration
{
    public function up()
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            // Add total_harga column if it doesn't exist
            if (!Schema::hasColumn('t_penjualan', 'total_harga')) {
                $table->integer('total_harga')->default(0)->after('customer');
            }
        });
    }

    public function down()
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            if (Schema::hasColumn('t_penjualan', 'total_harga')) {
                $table->dropColumn('total_harga');
            }
        });
    }
}