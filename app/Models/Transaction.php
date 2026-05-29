<?php

namespace App\Models;

// Import class Model bawaan Laravel
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Field yang boleh diisi menggunakan
     * mass assignment
     * 
     * Contoh:
     * Transaction::create([...])
     */
    protected $fillable = [

        // Tanggal transaksi
        'date',

        // Foreign key ke tabel coas
        'coa_id',

        // Keterangan/deskripsi transaksi
        'description',

        // Nilai debit
        'debit',

        // Nilai credit
        'credit'
    ];

    /**
     * Relasi Many To One
     * 
     * Banyak transaksi dimiliki oleh
     * satu COA
     * 
     * Contoh:
     * Banyak transaksi:
     * - bayar listrik
     * - beli barang
     * - pemasukan penjualan
     * 
     * bisa masuk ke satu akun tertentu
     */
    public function coa()
    {
        /**
         * belongsTo(Coa::class)
         * 
         * Artinya:
         * tabel transactions memiliki
         * foreign key:
         * coa_id
         * 
         * yang terhubung ke tabel coas
         */
        return $this->belongsTo(Coa::class);
    }
}