<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Exports\ProfitLossExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Menampilkan laporan laba rugi
     */
    public function profitLoss()
    {
        /**
         * Ambil semua transaksi
         * beserta relasi:
         * - coa
         * - category dari coa
         *
         * with() digunakan agar query lebih efisien
         * (eager loading)
         */
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->get();

        /**
         * DATA INCOME
         * Ambil transaksi yang memiliki credit > 0
         *
         * credit = pemasukan
         */
        $income = $transactions->where(
            'credit',
            '>',
            0
        );

        /**
         * DATA EXPENSE
         * Ambil transaksi yang memiliki debit > 0
         *
         * debit = pengeluaran
         */
        $expense = $transactions->where(
            'debit',
            '>',
            0
        );

        /**
         * TOTAL INCOME
         * Menjumlahkan semua nilai credit
         */
        $totalIncome = $income->sum('credit');

        /**
         * TOTAL EXPENSE
         * Menjumlahkan semua nilai debit
         */
        $totalExpense = $expense->sum('debit');

        /**
         * NET INCOME
         * laba bersih = income - expense
         */
        $netIncome = $totalIncome - $totalExpense;

        /**
         * Tampilkan halaman report
         * dan kirim semua data ke blade
         */
        return view(
            'dashboard.sections.report',
            compact(

                // daftar income
                'income',

                // daftar expense
                'expense',

                // total pemasukan
                'totalIncome',

                // total pengeluaran
                'totalExpense',

                // laba bersih
                'netIncome'
            )
        );
    }

    /**
     * Export laporan laba rugi ke Excel
     */
    public function exportExcel()
    {
        /**
         * Excel::download()
         * digunakan untuk generate & download file excel
         *
         * ProfitLossExport
         * = class export yang mengatur isi excel
         *
         * 'profit-loss-report.xlsx'
         * = nama file download
         */
        return Excel::download(
            new ProfitLossExport,
            'profit-loss-report.xlsx'
        );
    }
}