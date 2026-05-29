<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi dalam format JSON
     */
    public function index()
    {
        /**
         * Ambil semua transaksi
         * beserta relasi:
         * - coa
         * - category dari coa
         *
         * latest() = urut data terbaru
         */
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->latest()->get();

        // Return data JSON
        return response()->json($transactions);
    }

    /**
     * Menyimpan transaksi baru
     */
    public function store(Request $request)
    {
        /**
         * Membuat transaksi baru
         */
        Transaction::create([

            // tanggal transaksi
            'date' => $request->date,

            // id coa yang dipilih
            'coa_id' => $request->coa_id,

            // deskripsi transaksi
            'description' => $request->description,

            /**
             * debit ?? 0
             * jika debit kosong -> isi 0
             */
            'debit' => $request->debit ?? 0,

            /**
             * credit ?? 0
             * jika credit kosong -> isi 0
             */
            'credit' => $request->credit ?? 0,
        ]);

        /**
         * Redirect kembali ke halaman transaksi
         * dengan pesan sukses
         */
        return redirect('/transactions')
            ->with(
                'success',
                'Transaksi berhasil disimpan'
            );
    }

    /**
     * Menampilkan detail transaksi berdasarkan id
     */
    public function show($id)
    {
        /**
         * Cari transaksi berdasarkan id
         * beserta relasi coa & category
         *
         * findOrFail()
         * jika tidak ada -> error 404
         */
        $transaction = Transaction::with([
            'coa',
            'coa.category'
        ])->findOrFail($id);

        // Return JSON
        return response()->json($transaction);
    }

    /**
     * Mengupdate transaksi
     */
    public function update(Request $request, $id)
    {
        // Cari transaksi berdasarkan id
        $transaction = Transaction::findOrFail($id);

        // Update data transaksi
        $transaction->update([

            // tanggal transaksi
            'date' => $request->date,

            // coa yang dipilih
            'coa_id' => $request->coa_id,

            // deskripsi transaksi
            'description' => $request->description,

            // nilai debit
            'debit' => $request->debit,

            // nilai credit
            'credit' => $request->credit,
        ]);

        // Redirect kembali
        return redirect('/transactions')
            ->with(
                'success',
                'Transaksi berhasil diperbarui'
            );
    }

    /**
     * Menghapus transaksi
     */
    public function destroy($id)
    {
        /**
         * Cari transaksi berdasarkan id
         * lalu langsung hapus
         */
        Transaction::findOrFail($id)->delete();

        // Redirect kembali
        return redirect('/transactions')
            ->with(
                'success',
                'Transaksi berhasil dihapus'
            );
    }

    /**
     * Menampilkan halaman transaksi
     * dengan fitur:
     * - search
     * - filter
     * - sorting
     */
    public function view(Request $request)
    {
        /**
         * Query awal transaksi
         * beserta relasi coa & category
         */
        $query = Transaction::with([
            'coa',
            'coa.category'
        ]);

        /**
         * SEARCH
         */
        if ($request->filled('search')) {

            // keyword pencarian
            $search = $request->search;

            /**
             * Cari berdasarkan:
             * - description transaksi
             * - nama coa
             * - kode coa
             */
            $query->where(function ($q) use ($search) {

                // Cari di description
                $q->where(
                    'description',
                    'like',
                    "%{$search}%"
                )

                /**
                 * orWhereHas('coa')
                 * mencari pada relasi coa
                 */
                ->orWhereHas('coa', fn($q2) => $q2

                    // cari berdasarkan nama coa
                    ->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )

                    // atau kode coa
                    ->orWhere(
                        'code',
                        'like',
                        "%{$search}%"
                    )
                );
            });
        }

        /**
         * FILTER DATE FROM
         * Ambil transaksi dari tanggal tertentu
         */
        if ($request->filled('date_from')) {

            $query->whereDate(
                'date',
                '>=',
                $request->date_from
            );
        }

        /**
         * FILTER DATE TO
         * Ambil transaksi sampai tanggal tertentu
         */
        if ($request->filled('date_to')) {

            $query->whereDate(
                'date',
                '<=',
                $request->date_to
            );
        }

        /**
         * FILTER CATEGORY
         */
        if ($request->filled('category_id')) {

            /**
             * whereHas('coa')
             * filter transaksi berdasarkan
             * category pada relasi coa
             */
            $query->whereHas(
                'coa',
                fn($q) => $q->where(
                    'category_id',
                    $request->category_id
                )
            );
        }

        /**
         * FILTER COA
         */
        if ($request->filled('coa_id')) {

            // Filter berdasarkan coa_id
            $query->where(
                'coa_id',
                $request->coa_id
            );
        }

        /**
         * SORTING DATA
         */
        match ($request->sort) {

            /**
             * Urut tanggal terlama
             */
            'oldest' => $query->oldest('date'),

            /**
             * Urut debit terbesar
             */
            'debit_desc' => $query->orderByDesc('debit'),

            /**
             * Urut credit terbesar
             */
            'credit_desc' => $query->orderByDesc('credit'),

            /**
             * Default:
             * urut tanggal terbaru
             */
            default => $query->latest('date'),
        };

        /**
         * Eksekusi query transaksi
         */
        $transactions = $query->get();

        /**
         * Ambil semua COA
         * biasanya untuk dropdown
         */
        $coas = Coa::latest()->get();

        /**
         * Ambil semua category
         * biasanya untuk dropdown
         */
        $categories = Category::latest()->get();

        /**
         * Tampilkan halaman transaksi
         * dan kirim data ke blade
         */
        return view(
            'dashboard.sections.transactions',
            compact(
                'transactions',
                'coas',
                'categories'
            )
        );
    }
}