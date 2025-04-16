<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Transaction History',
            'list' => ['Home', 'Transactions', 'History']
        ];

        $transactions = PenjualanModel::with('details.barang', 'user')->latest()->get();

        return view('transactions.index', [
            'breadcrumb' => $breadcrumb,
            'transactions' => $transactions,
            'activeMenu' => 'transactions'
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Create Transaction',
            'list' => ['Home', 'Transactions', 'Create']
        ];

        $items = BarangModel::where('stok', '>', 0)->get();

        return view('transactions.create', [
            'breadcrumb' => $breadcrumb,
            'items' => $items,
            'activeMenu' => 'transactions'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.barang_id' => 'required|exists:m_barang,barang_id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // Get the last transaction with 'PJ' prefix
            $lastTransaction = PenjualanModel::where('penjualan_kode', 'like', 'PJ%')
                ->orderBy('penjualan_kode', 'desc')
                ->first();

            // Extract the numeric part and increment
            if ($lastTransaction) {
                $lastNumber = (int) substr($lastTransaction->penjualan_kode, 2); // Extract number after 'PJ'
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1; // Start from 1 if no previous PJ codes exist
            }

            // Format the new transaction code as PJXXXX (e.g., PJ0010)
            $penjualanKode = 'PJ' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Create transaction header
            $penjualan = PenjualanModel::create([
                'penjualan_kode' => $penjualanKode,
                'penjualan_tanggal' => now(),
                'customer' => $request->customer,
                'user_id' => auth()->id(),
                'total_harga' => 0
            ]);

            $total = 0;

            foreach ($request->items as $itemData) {
                $barang = BarangModel::findOrFail($itemData['barang_id']);
                if ($barang->stok < $itemData['jumlah']) {
                    throw new \Exception("Stock for {$barang->barang_nama} is insufficient!");
                }

                $hargaJual = intval($barang->harga_jual);
                $subtotal = $hargaJual * $itemData['jumlah'];

                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $itemData['barang_id'],
                    'harga' => $hargaJual,
                    'jumlah' => $itemData['jumlah'],
                    'subtotal' => $subtotal
                ]);

                $barang->decrement('stok', $itemData['jumlah']);
                $total += $subtotal;
            }

            $penjualan->update(['total_harga' => $total]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaction created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}