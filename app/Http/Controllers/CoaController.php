<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Category;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Menampilkan semua data COA beserta category
     * dalam format JSON
     */
    public function index()
    {
        /**
         * with('category')
         * digunakan untuk mengambil relasi category
         * agar tidak query berulang (eager loading)
         */
        $coas = Coa::with('category')->latest()->get();

        // Return data JSON
        return response()->json($coas);
    }

    /**
     * Menyimpan data COA baru
     */
    public function store(Request $request)
    {
        // Membuat data COA baru
        Coa::create([

            // kode akun
            'code' => $request->code,

            // nama akun
            'name' => $request->name,

            // foreign key category
            'category_id' => $request->category_id
        ]);

        // Redirect ke halaman COA
        // dengan pesan berhasil
        return redirect('/coas')
            ->with('success', 'COA created');
    }

    /**
     * Menampilkan detail 1 COA berdasarkan id
     */
    public function show($id)
    {
        /**
         * Ambil data COA + relasi category
         * findOrFail() -> jika tidak ada, error 404
         */
        $coa = Coa::with('category')->findOrFail($id);

        // Return data JSON
        return response()->json($coa);
    }

    /**
     * Mengupdate data COA
     */
    public function update(Request $request, $id)
    {
        // Cari data COA berdasarkan id
        $coa = Coa::findOrFail($id);

        // Update data
        $coa->update([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        // Redirect kembali ke halaman COA
        return redirect('/coas')
            ->with('success', 'COA updated');
    }

    /**
     * Menghapus data COA
     */
    public function destroy($id)
    {
        // Cari data COA
        $coa = Coa::findOrFail($id);

        // Hapus data
        $coa->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/coas')
            ->with('success', 'COA deleted');
    }

    /**
     * Menampilkan halaman view COA
     * beserta fitur search & filter category
     */
    public function view(Request $request)
    {
        /**
         * Query awal
         * with('category') agar relasi category ikut diambil
         */
        $query = Coa::with('category');

        /**
         * SEARCH
         * Jika user mengisi keyword search
         */
        if ($request->search) {

            /**
             * where(function($q))
             * digunakan agar query OR tetap dalam 1 grup
             *
             * SQL:
             * WHERE (
             *   code LIKE '%keyword%'
             *   OR name LIKE '%keyword%'
             * )
             */
            $query->where(function ($q) use ($request) {

                $q->where(
                    'code',
                    'like',
                    '%' . $request->search . '%'
                )

                // ATAU cari berdasarkan nama
                ->orWhere(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }

        /**
         * FILTER CATEGORY
         * Jika category dipilih
         */
        if ($request->category_id) {

            // Ambil data sesuai category_id
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        /**
         * Eksekusi query
         * latest() = urut terbaru
         */
        $coas = $query->latest()->get();

        /**
         * Ambil semua category
         * biasanya untuk dropdown filter/form
         */
        $categories = Category::latest()->get();

        /**
         * Tampilkan halaman blade
         * sambil kirim data coas & categories
         */
        return view(
            'dashboard.sections.coas',
            compact('coas', 'categories')
        );
    }
}