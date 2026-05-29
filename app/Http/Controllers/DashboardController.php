<?php

namespace App\Http\Controllers;

// Import DB Facade untuk query manual/raw query builder
use Illuminate\Support\Facades\DB;

// Import model yang digunakan
use App\Models\Category;
use App\Models\Coa;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard
     */
    public function index()
    {
        /**
         * Menghitung total seluruh category
         * 
         * SELECT COUNT(*) FROM categories
         */
        $totalCategories = Category::count();

        /**
         * Menghitung total seluruh COA
         */
        $totalCoas = Coa::count();

        /**
         * Menghitung total seluruh transaksi
         */
        $totalTransactions = Transaction::count();

        /**
         * Menghitung jumlah transaksi income
         * 
         * credit > 0 dianggap pemasukan
         */
        $totalIncome1 = Transaction::where('credit', '>', 0)->count();

        /**
         * Menghitung jumlah transaksi expense
         * 
         * debit > 0 dianggap pengeluaran
         */
        $totalExpense1 = Transaction::where('debit', '>', 0)->count();

        /**
         * Menjumlahkan seluruh nilai credit
         * 
         * total pemasukan
         */
        $totalIncome = Transaction::sum('credit');

        /**
         * Menjumlahkan seluruh nilai debit
         * 
         * total pengeluaran
         */
        $totalExpense = Transaction::sum('debit');

        /**
         * Menghitung laba bersih
         * 
         * laba = pemasukan - pengeluaran
         */
        $netIncome = $totalIncome - $totalExpense;

        /**
         * Mengambil 5 COA yang paling sering digunakan
         * 
         * Query Builder:
         * - join transactions dengan coas
         * - join coas dengan categories
         * - hitung jumlah transaksi tiap COA
         */
        $mostUsedCoas = DB::table('transactions')

            /**
             * Join tabel transactions dengan tabel coas
             * 
             * transactions.coa_id = coas.id
             */
            ->join(
                'coas',
                'transactions.coa_id',
                '=',
                'coas.id'
            )

            /**
             * Join tabel coas dengan categories
             * 
             * coas.category_id = categories.id
             */
            ->join(
                'categories',
                'coas.category_id',
                '=',
                'categories.id'
            )

            /**
             * Pilih data yang ingin ditampilkan
             */
            ->select(

                // Nama COA
                'coas.name as coa_name',

                // Nama category
                'categories.name as category_name',

                /**
                 * COUNT(transactions.id)
                 * menghitung jumlah transaksi
                 * tiap COA
                 */
                DB::raw('COUNT(transactions.id) as total_transactions')
            )

            /**
             * Group data berdasarkan:
             * - nama COA
             * - nama category
             */
            ->groupBy(
                'coas.name',
                'categories.name'
            )

            /**
             * Urutkan dari transaksi terbanyak
             */
            ->orderByDesc('total_transactions')

            /**
             * Ambil hanya 5 data teratas
             */
            ->limit(5)

            /**
             * Eksekusi query
             */
            ->get();

        /**
         * Tampilkan halaman dashboard.index
         * sambil mengirim semua data
         */
        return view('dashboard.index', compact(

            // Total category
            'totalCategories',

            // Total COA
            'totalCoas',

            // Total transaksi
            'totalTransactions',

            // Total transaksi income
            'totalIncome1',

            // Total transaksi expense
            'totalExpense1',

            // Total nominal income
            'totalIncome',

            // Total nominal expense
            'totalExpense',

            // Laba bersih
            'netIncome',

            // COA paling sering dipakai
            'mostUsedCoas'
        ));
    }
}