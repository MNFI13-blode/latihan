<?php

namespace App\Exports;

// Import model Transaction
use App\Models\Transaction;

// Collection digunakan untuk menampung data sementara
use Illuminate\Support\Collection;

// Interface FromCollection dari Laravel Excel
// Menandakan bahwa export akan mengambil data dari collection()
use Maatwebsite\Excel\Concerns\FromCollection;

class ProfitLossExport implements FromCollection
{
    /**
     * Method ini WAJIB ada karena class menggunakan FromCollection
     * Semua data yang direturn di sini akan dijadikan isi file Excel
     */
    public function collection()
    {
        /**
         * Ambil semua transaksi beserta relasinya
         * - coa           => relasi chart of account
         * - coa.category  => relasi category dari coa
         * 
         * with() dipakai agar tidak terjadi N+1 Query
         * Jadi relasi langsung di-load sekali
         */
        $transactions = Transaction::with([
            'coa',
            'coa.category'
        ])->get();

        /**
         * Buat collection kosong untuk menampung
         * hasil akhir data export
         */
        $rows = collect();

        /**
         * LOOP SEMUA TRANSAKSI YANG MEMILIKI CREDIT > 0
         * 
         * Dianggap sebagai Income / pemasukan
         */
        foreach ($transactions->where('credit', '>', 0) as $item) {

            /**
             * Tambahkan data ke collection $rows
             * push() = menambahkan item baru ke collection
             */
            $rows->push([

                // Kolom Type
                'Type' => 'Income',

                // Nama COA
                // ?? '-' dipakai kalau data null
                'COA' => $item->coa->name ?? '-',

                // Nama category dari COA
                'Category' => $item->coa->category->name ?? '-',

                // Nilai credit dimasukkan sebagai amount
                'Amount' => $item->credit
            ]);
        }

        /**
         * LOOP SEMUA TRANSAKSI YANG MEMILIKI DEBIT > 0
         * 
         * Dianggap sebagai Expense / pengeluaran
         */
        foreach ($transactions->where('debit', '>', 0) as $item) {

            /**
             * Tambahkan data expense ke collection
             */
            $rows->push([

                // Kolom Type
                'Type' => 'Expense',

                // Nama COA
                'COA' => $item->coa->name ?? '-',

                // Nama category
                'Category' => $item->coa->category->name ?? '-',

                // Nilai debit dijadikan amount
                'Amount' => $item->debit
            ]);
        }

        /**
         * Return collection akhir
         * 
         * Data inilah yang nanti diproses oleh
         * Laravel Excel menjadi file .xlsx
         */
        return $rows;
    }
}