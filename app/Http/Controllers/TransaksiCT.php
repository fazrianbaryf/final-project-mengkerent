<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarUnits;
use App\Models\CustomerTransaction;
use App\Models\OrderHistory;

class TransaksiCT extends Controller
{
    public function index()
    {
        $transactions = CustomerTransaction::all();

        return view('transaksi-customer', [
            'transactions' => $transactions,
            'title' => 'Transaksi Customer'
        ]);
    }

    // Method untuk menyelesaikan transaksi dan memindahkan data ke order-history
    public function completeTransaction($id, Request $request)
    {
        // Ambil data transaksi berdasarkan ID
        $transaction = CustomerTransaction::findOrFail($id);

        // Validasi status transaksi yang dapat dipindahkan
        if (!in_array($transaction->status, ['Menunggu Konfirmasi', 'ditolak', 'dicancel'])) {
            return back()->with('error', 'Transaksi dengan status ini tidak dapat diselesaikan.');
        }

        // Update status transaksi menjadi 'selesai'
        $transaction->status = 'selesai';
        $transaction->save();

        // Buat entry baru di order-history
        OrderHistory::create([
            'user_id' => $transaction->user_id,
            'customer_name' => $transaction->customer_name,
            'nama_mobil' => $transaction->nama_mobil,
            'plat_mobil' => $transaction->plat_mobil,
            'durasi' => $transaction->durasi,
            'harga' => $transaction->harga,
            'no_telfon' => $transaction->no_telfon,
            'pelayanan' => $transaction->pelayanan,
            'alamat' => $transaction->alamat,
            'status' => 'selesai' // Set status ke 'selesai'
        ]);

        // Hapus transaksi dari tabel customer_transactions
        $transaction->delete();

        // Ubah status car unit menjadi 'tersedia'
        $carUnit = CarUnits::find($transaction->car_unit_id);
        if ($carUnit) {
            $carUnit->status = 'tersedia';
            $carUnit->save();
        }

        return back()->with('success', 'Transaction completed and moved to order history successfully.');
    }
}