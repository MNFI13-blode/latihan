<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
         * TOTAL CATEGORY
         * Menghitung jumlah semua category
         */
        $totalCategories = Category::count();

        /**
         * TOTAL COA
         * Menghitung jumlah semua chart of account
         */
        $totalCoas = Coa::count();

        /**
         * TOTAL TRANSACTION
         * Menghitung seluruh transaksi
         */
        $totalTransactions = Transaction::count();

        /**
         * TOTAL INCOME TRANSACTION
         * Menghitung jumlah transaksi
         * yang memiliki credit > 0
         *
         * count() = jumlah data transaksi
         */
        $totalIncome1 = Transaction::where(
            'credit',
            '>',
            0
        )->count();

        /**
         * TOTAL EXPENSE TRANSACTION
         * Menghitung jumlah transaksi
         * yang memiliki debit > 0
         */
        $totalExpense1 = Transaction::where(
            'debit',
            '>',
            0
        )->count();

        /**
         * TOTAL INCOME
         * Menjumlahkan seluruh nilai credit
         *
         * sum('credit') = total pemasukan
         */
        $totalIncome = Transaction::sum('credit');

        /**
         * TOTAL EXPENSE
         * Menjumlahkan seluruh nilai debit
         *
         * sum('debit') = total pengeluaran
         */
        $totalExpense = Transaction::sum('debit');

        /**
         * NET INCOME
         * laba bersih = pemasukan - pengeluaran
         */
        $netIncome = $totalIncome - $totalExpense;

        /**
         * MOST USED COAS
         * Mengambil 5 COA yang paling sering dipakai
         */
        $mostUsedCoas = DB::table('transactions')

            /**
             * JOIN ke tabel coas
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
             * JOIN ke tabel categories
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
             * SELECT data yang ingin diambil
             */
            ->select(

                // nama COA
                'coas.name as coa_name',

                // nama category
                'categories.name as category_name',

                /**
                 * COUNT(transactions.id)
                 * menghitung jumlah transaksi
                 * pada tiap COA
                 */
                DB::raw(
                    'COUNT(transactions.id) as total_transactions'
                )
            )

            /**
             * GROUP BY
             * agar COUNT dihitung per COA
             */
            ->groupBy(
                'coas.name',
                'categories.name'
            )

            /**
             * ORDER BY DESC
             * urutkan dari transaksi terbanyak
             */
            ->orderByDesc('total_transactions')

            /**
             * LIMIT 5
             * ambil 5 data teratas
             */
            ->limit(5)

            // Eksekusi query
            ->get();

        /**
         * Kirim semua data ke dashboard blade
         */
        return view('dashboard.index', compact(

            // total category
            'totalCategories',

            // total coa
            'totalCoas',

            // total transaksi
            'totalTransactions',

            // jumlah transaksi income
            'totalIncome1',

            // jumlah transaksi expense
            'totalExpense1',

            // total income nominal
            'totalIncome',

            // total expense nominal
            'totalExpense',

            // laba bersih
            'netIncome',

            // COA paling sering dipakai
            'mostUsedCoas'
        ));
    }
}