<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Monolog\Level;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            LevelSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            SupplierSeeder::class,
            BarangSeeder::class,
            StokSeeder::class,
            PenjualanSeeder::class,
            PenjualanDetailSeeder::class,
            BarangStockSeeder::class,
        ]);
    }
}
