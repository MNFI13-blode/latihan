<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->latest()->get();

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        Transaction::create([
            'date' => $request->date,
            'coa_id' => $request->coa_id,
            'description' => $request->description,
            'debit' => $request->debit ?? 0,
            'credit' => $request->credit ?? 0
        ]);

        return redirect('/transactions')
            ->with('success', 'Transaction created');
    }

    public function show($id)
    {
        $transaction = Transaction::with([
            'coa',
            'coa.category'
        ])->findOrFail($id);

        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'date' => $request->date,
            'coa_id' => $request->coa_id,
            'description' => $request->description,
            'debit' => $request->debit,
            'credit' => $request->credit
        ]);

        return redirect('/transactions')
            ->with('success', 'Transaction updated');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return redirect('/transactions')
            ->with('success', 'Transaction deleted');
    }

    public function view()
    {
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->latest()->get();

        $coas = Coa::latest()->get();

        return view(
            'dashboard.sections.transactions',
            compact('transactions', 'coas')
        );
    }
}
