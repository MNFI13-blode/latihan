<?php

namespace App\Http\Controllers;

// Import model COA
use App\Models\Coa;

// Import model Transaction
use App\Models\Transaction;

// Import Request untuk mengambil input user
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi
     */
    public function index()
    {
        /**
         * Ambil semua transaksi beserta relasi:
         * - coa
         * - category dari coa
         * 
         * latest()
         * urut berdasarkan data terbaru
         */
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->latest()->get();

        /**
         * Return data dalam format JSON
         */
        return response()->json($transactions);
    }

    /**
     * Menyimpan transaksi baru
     */
    public function store(Request $request)
    {
        /**
         * Insert data transaksi ke database
         */
        Transaction::create([

            // Tanggal transaksi
            'date' => $request->date,

            // Foreign key ke tabel coas
            'coa_id' => $request->coa_id,

            // Deskripsi transaksi
            'description' => $request->description,

            /**
             * Debit transaksi
             * 
             * ?? 0 artinya:
             * jika input kosong/null
             * maka isi default 0
             */
            'debit' => $request->debit ?? 0,

            /**
             * Credit transaksi
             * 
             * jika kosong => 0
             */
            'credit' => $request->credit ?? 0
        ]);

        /**
         * Redirect kembali ke halaman transactions
         * dengan pesan sukses
         */
        return redirect('/transactions')
            ->with('success', 'Transaction created');
    }

    /**
     * Menampilkan detail transaksi berdasarkan id
     */
    public function show($id)
    {
        /**
         * Cari transaksi berdasarkan id
         * beserta relasinya
         * 
         * findOrFail():
         * - jika data ada => return data
         * - jika tidak ada => otomatis 404
         */
        $transaction = Transaction::with([
            'coa',
            'coa.category'
        ])->findOrFail($id);

        /**
         * Return data transaksi dalam JSON
         */
        return response()->json($transaction);
    }

    /**
     * Update transaksi
     */
    public function update(Request $request, $id)
    {
        /**
         * Cari transaksi berdasarkan id
         */
        $transaction = Transaction::findOrFail($id);

        /**
         * Update data transaksi
         */
        $transaction->update([

            // Update tanggal
            'date' => $request->date,

            // Update coa
            'coa_id' => $request->coa_id,

            // Update deskripsi
            'description' => $request->description,

            // Update debit
            'debit' => $request->debit,

            // Update credit
            'credit' => $request->credit
        ]);

        /**
         * Redirect kembali dengan pesan sukses
         */
        return redirect('/transactions')
            ->with('success', 'Transaction updated');
    }

    /**
     * Hapus transaksi
     */
    public function destroy($id)
    {
        /**
         * Cari transaksi berdasarkan id
         */
        $transaction = Transaction::findOrFail($id);

        /**
         * Hapus data transaksi dari database
         */
        $transaction->delete();

        /**
         * Redirect kembali dengan flash message
         */
        return redirect('/transactions')
            ->with('success', 'Transaction deleted');
    }

    /**
     * Menampilkan halaman transaksi
     */
    public function view()
    {
        /**
         * Ambil semua transaksi
         * beserta relasi:
         * - coa
         * - category
         */
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->latest()->get();

        /**
         * Ambil semua data COA
         * untuk dropdown form transaksi
         */
        $coas = Coa::latest()->get();

        /**
         * Tampilkan halaman:
         * dashboard.sections.transactions
         * 
         * compact():
         * mengirim data ke view
         */
        return view(
            'dashboard.sections.transactions',
            compact('transactions', 'coas')
        );
    }
}