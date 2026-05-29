<?php

namespace App\Http\Controllers;

// Import model Transaction
use App\Models\Transaction;

// Import class export Excel
use App\Exports\ProfitLossExport;

// Facade Excel dari Laravel Excel
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan laba rugi
     */
    public function profitLoss()
    {
        /**
         * Ambil semua transaksi beserta relasinya:
         * - coa
         * - category dari coa
         * 
         * with() digunakan untuk eager loading
         * agar query lebih efisien
         */
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->get();

        /**
         * Ambil semua transaksi income
         * 
         * credit > 0 dianggap pemasukan
         */
        $income = $transactions->where('credit', '>', 0);

        /**
         * Ambil semua transaksi expense
         * 
         * debit > 0 dianggap pengeluaran
         */
        $expense = $transactions->where('debit', '>', 0);

        /**
         * Hitung total seluruh income
         * 
         * Menjumlahkan field credit
         */
        $totalIncome = $income->sum('credit');

        /**
         * Hitung total seluruh expense
         * 
         * Menjumlahkan field debit
         */
        $totalExpense = $expense->sum('debit');

        /**
         * Hitung laba bersih
         * 
         * laba = income - expense
         */
        $netIncome = $totalIncome - $totalExpense;

        /**
         * Tampilkan halaman report
         * sambil mengirim data:
         * 
         * - income
         * - expense
         * - total income
         * - total expense
         * - net income
         */
        return view(
            'dashboard.sections.report',
            compact(
                'income',
                'expense',
                'totalIncome',
                'totalExpense',
                'netIncome'
            )
        );
    }

    /**
     * Export laporan laba rugi ke file Excel
     */
    public function exportExcel()
    {
        /**
         * Excel::download()
         * digunakan untuk download file excel
         * 
         * Parameter:
         * 1. class export
         * 2. nama file hasil download
         */
        return Excel::download(

            // Class export yang berisi data laporan
            new ProfitLossExport,

            // Nama file excel
            'profit-loss-report.xlsx'
        );
    }
}