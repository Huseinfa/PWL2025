<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'penjualan_id' => $i,
                'penjualan_kode' => sprintf('PJ%04d', $i), // e.g., PJ0001, PJ0002, ...
                'penjualan_tanggal' => now(),
                'customer' => "Pembeli{$i}", // Use 'customer' instead of 'pembeli'
                'user_id' => 3,
                'total_harga' => 0, // Will be updated later based on t_penjualan_detail
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}