<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;


class ProfitLossExport implements FromCollection
{
    public function collection()
    {
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->get();
        $rows = collect();
        foreach ($transactions->where('credit', '>', 0) as $item) {

            $rows->push([
                'Type' => 'Income',
                'COA' => $item->coa->name ?? '-',
                'Category' => $item->coa->category->name ?? '-',
                'Amount' => $item->credit
            ]);
        }
        foreach ($transactions->where('debit', '>', 0) as $item) {

            $rows->push([
                'Type' => 'Expense',
                'COA' => $item->coa->name ?? '-',
                'Category' => $item->coa->category->name ?? '-',
                'Amount' => $item->debit
            ]);
        }

        return $rows;
    }
}