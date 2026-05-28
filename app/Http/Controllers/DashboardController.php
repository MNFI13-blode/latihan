<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Coa;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalCoas = Coa::count();
        $totalTransactions = Transaction::count();
        $totalIncome1 = Transaction::where('credit', '>', 0)->count();
        $totalExpense1 = Transaction::where('debit', '>', 0)->count();
        $totalIncome = Transaction::sum('credit');
        $totalExpense = Transaction::sum('debit');
        $netIncome = $totalIncome - $totalExpense;
        $mostUsedCoas = DB::table('transactions')
            ->join(
                'coas',
                'transactions.coa_id',
                '=',
                'coas.id'
            )
            ->join(
                'categories',
                'coas.category_id',
                '=',
                'categories.id'
            )
            ->select(
                'coas.name as coa_name',
                'categories.name as category_name',
                DB::raw('COUNT(transactions.id) as total_transactions')
            )
            ->groupBy(
                'coas.name',
                'categories.name'
            )
            ->orderByDesc('total_transactions')
            ->limit(5)
            ->get();
        return view('dashboard.index', compact(
            'totalCategories',
            'totalCoas',
            'totalTransactions',
            'totalIncome1',
            'totalExpense1',
            'totalIncome',
            'totalExpense',
            'netIncome',
            'mostUsedCoas'
        ));
    }
}