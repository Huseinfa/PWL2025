<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePembeliToCustomerInTPenjualanTable extends Migration
{
    public function up()
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            // Rename pembeli to customer
            if (Schema::hasColumn('t_penjualan', 'pembeli')) {
                $table->renameColumn('pembeli', 'customer');
            }
        });
    }

    public function down()
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            if (Schema::hasColumn('t_penjualan', 'customer')) {
                $table->renameColumn('customer', 'pembeli');
            }
        });
    }
}