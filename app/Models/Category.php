<?php

namespace App\Models;

// Import class Model bawaan Laravel
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Field yang boleh diisi secara mass assignment
     * 
     * Contoh:
     * Category::create([...])
     * 
     * Hanya field yang ada di $fillable
     * yang boleh diinsert/update
     */
    protected $fillable = [

        // Nama category
        'name'
    ];

    /**
     * Relasi One To Many
     * 
     * Satu category bisa memiliki banyak COA
     * 
     * Contoh:
     * Category "Asset"
     * bisa punya:
     * - Cash
     * - Bank
     * - Inventory
     */
    public function coas()
    {
        /**
         * hasMany(Coa::class)
         * 
         * Artinya:
         * tabel categories
         * memiliki banyak data di tabel coas
         * 
         * Foreign key default:
         * category_id
         */
        return $this->hasMany(Coa::class);
    }
}