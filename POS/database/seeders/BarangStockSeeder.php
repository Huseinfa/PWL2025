<?php

namespace Database\Seeders;

use App\Models\BarangModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class BarangStockSeeder extends Seeder
{
    public function run()
    {
        // Fetch all items from m_barang
        $items = BarangModel::all();

        // Ensure there are 17 items
        if ($items->count() !== 17) {
            Log::warning("Expected 17 items in m_barang, but found {$items->count()} items.");
        }

        // Update each item with a random stock value between 1 and 100
        foreach ($items as $item) {
            $item->stok = rand(1, 100); // Random stock between 1 and 100
            $item->save();
        }
        Log::info("Stock updated for {$items->count()} items in m_barang table.");

    }
}