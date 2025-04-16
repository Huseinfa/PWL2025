<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $hargaValues = [2500000, 4000000, 20000, 5000, 5000, 55000, 60000, 200000, 30000, 70000];
        $jumlahValues = [1, 4, 4, 5, 4, 2, 4, 3, 1, 5];

        for ($i = 1; $i <= 10; $i++) {
            $harga = $hargaValues[$i - 1];
            $jumlah = $jumlahValues[$i - 1];
            $subtotal = $harga * $jumlah;
            $data[] = [
                'detail_id' => $i,
                'penjualan_id' => $i, // Matches penjualan_id from t_penjualan
                'barang_id' => $i, // Assumes barang_id 1 to 10 exist in m_barang
                'harga' => $harga,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan_detail')->insert($data);

        // Update total_harga in t_penjualan based on the subtotals
        for ($i = 1; $i <= 10; $i++) {
            $total = DB::table('t_penjualan_detail')
                ->where('penjualan_id', $i)
                ->sum('subtotal');
            DB::table('t_penjualan')
                ->where('penjualan_id', $i)
                ->update(['total_harga' => $total]);
        }
    }
}