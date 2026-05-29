<?php

namespace App\Models;

// Import class Model bawaan Laravel
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    /**
     * Field yang boleh diisi menggunakan
     * mass assignment
     * 
     * Contoh:
     * Coa::create([...])
     */
    protected $fillable = [

        // Kode akun
        'code',

        // Nama akun
        'name',

        // Foreign key ke tabel categories
        'category_id'
    ];

    /**
     * Relasi Many To One
     * 
     * Banyak COA dimiliki oleh
     * satu category
     * 
     * Contoh:
     * COA "Cash"
     * termasuk category "Asset"
     */
    public function category()
    {
        /**
         * belongsTo(Category::class)
         * 
         * Artinya:
         * tabel coas memiliki foreign key:
         * category_id
         * 
         * yang terhubung ke tabel categories
         */
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi One To Many
     * 
     * Satu COA bisa memiliki
     * banyak transaksi
     * 
     * Contoh:
     * COA "Cash"
     * punya banyak transaksi:
     * - pemasukan
     * - pengeluaran
     */
    public function transactions()
    {
        /**
         * hasMany(Transaction::class)
         * 
         * Artinya:
         * satu data COA
         * memiliki banyak data transaction
         * 
         * Foreign key default:
         * coa_id
         */
        return $this->hasMany(Transaction::class);
    }
}