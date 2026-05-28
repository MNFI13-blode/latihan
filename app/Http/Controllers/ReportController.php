<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Exports\ProfitLossExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function profitLoss()
    {
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->get();

        $income = $transactions->where('credit', '>', 0);
        $expense = $transactions->where('debit', '>', 0);

        $totalIncome = $income->sum('credit');
        $totalExpense = $expense->sum('debit');

        $netIncome = $totalIncome - $totalExpense;

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
    public function exportExcel()
    {
        return Excel::download(
            new ProfitLossExport,
            'profit-loss-report.xlsx'
        );
    }
}
