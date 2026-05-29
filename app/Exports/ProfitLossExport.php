<?php

namespace App\Exports;

use App\Models\Transaction;

/*
    Interface untuk export data collection
    ke Excel
*/
use Maatwebsite\Excel\Concerns\FromCollection;

/*
    Interface untuk membuat heading
    pada file Excel
*/
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitLossExport implements FromCollection, WithHeadings
{
    // =====================================================
    // MENGAMBIL DATA UNTUK EXPORT EXCEL
    // =====================================================
    public function collection()
    {
        /*
            Mengambil semua transaksi
            beserta relasi:
            - coa
            - category dari coa
        */
        $transactions = Transaction::with([

            'coa',

            'coa.category'

        ])->get();

        /*
            Membuat collection kosong
            untuk menampung row excel
        */
        $rows = collect();

        /*
            Variabel total income
        */
        $totalIncome = 0;

        /*
            Variabel total expense
        */
        $totalExpense = 0;

        // =================================================
        // LOOP DATA INCOME
        // =================================================

        /*
            Mengambil transaksi
            yang memiliki credit > 0
        */
        foreach (
            $transactions->where('credit', '>', 0)
            as $item
        ) {

            /*
                Menambahkan total income
            */
            $totalIncome += $item->credit;

            /*
                Menambahkan row
                ke collection
            */
            $rows->push([

                /*
                    Tanggal transaksi
                */
                'date' => $item->created_at
                    ->format('Y-m-d'),

                /*
                    Jenis transaksi
                */
                'type' => 'Income',

                /*
                    Nama COA
                */
                'coa' => $item->coa->name ?? '-',

                /*
                    Nama category
                */
                'category' =>
                    $item->coa->category->name ?? '-',

                /*
                    Deskripsi transaksi
                */
                'description' =>
                    $item->description ?? '-',

                /*
                    Jumlah income
                */
                'amount' => $item->credit,
            ]);
        }

        // =================================================
        // LOOP DATA EXPENSE
        // =================================================

        /*
            Mengambil transaksi
            yang memiliki debit > 0
        */
        foreach (
            $transactions->where('debit', '>', 0)
            as $item
        ) {

            /*
                Menambahkan total expense
            */
            $totalExpense += $item->debit;

            /*
                Menambahkan row
                ke collection
            */
            $rows->push([

                /*
                    Tanggal transaksi
                */
                'date' => $item->created_at
                    ->format('Y-m-d'),

                /*
                    Jenis transaksi
                */
                'type' => 'Expense',

                /*
                    Nama COA
                */
                'coa' => $item->coa->name ?? '-',

                /*
                    Nama category
                */
                'category' =>
                    $item->coa->category->name ?? '-',

                /*
                    Deskripsi transaksi
                */
                'description' =>
                    $item->description ?? '-',

                /*
                    Jumlah expense
                */
                'amount' => $item->debit,
            ]);
        }

        // =================================================
        // BARIS KOSONG PEMBATAS
        // =================================================

        $rows->push([]);

        // =================================================
        // TOTAL INCOME
        // =================================================

        $rows->push([

            'date' => '',

            'type' => '',

            'coa' => '',

            'category' => '',

            /*
                Label total income
            */
            'description' => 'Total Income',

            /*
                Nilai total income
            */
            'amount' => $totalIncome,
        ]);

        // =================================================
        // TOTAL EXPENSE
        // =================================================

        $rows->push([

            'date' => '',

            'type' => '',

            'coa' => '',

            'category' => '',

            /*
                Label total expense
            */
            'description' => 'Total Expense',

            /*
                Nilai total expense
            */
            'amount' => $totalExpense,
        ]);

        // =================================================
        // NET PROFIT
        // =================================================

        $rows->push([

            'date' => '',

            'type' => '',

            'coa' => '',

            'category' => '',

            /*
                Label net profit
            */
            'description' => 'Net Profit',

            /*
                Profit bersih
                = income - expense
            */
            'amount' =>
                $totalIncome - $totalExpense,
        ]);

        /*
            Return semua row
            untuk dijadikan file Excel
        */
        return $rows;
    }

    // =====================================================
    // HEADER KOLOM EXCEL
    // =====================================================
    public function headings(): array
    {
        /*
            Nama header
            pada file Excel
        */
        return [

            'Date',

            'Type',

            'COA',

            'Category',

            'Description',

            'Amount',
        ];
    }
}