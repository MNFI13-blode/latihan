<?php

namespace App\Http\Controllers;

// Import model COA
use App\Models\Coa;

// Import model Category
use App\Models\Category;

// Import Request untuk mengambil input user
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Menampilkan semua data COA
     */
    public function index()
    {
        /**
         * Ambil semua data COA beserta relasi category
         * 
         * with('category')
         * digunakan agar category langsung ikut diambil
         * (eager loading)
         * 
         * latest()
         * urut berdasarkan created_at terbaru
         */
        $coas = Coa::with('category')->latest()->get();

        /**
         * Return data dalam bentuk JSON
         */
        return response()->json($coas);
    }

    /**
     * Menyimpan data COA baru
     */
    public function store(Request $request)
    {
        /**
         * Insert data baru ke tabel coas
         */
        Coa::create([

            // Kode akun
            'code' => $request->code,

            // Nama akun
            'name' => $request->name,

            // Foreign key category
            'category_id' => $request->category_id
        ]);

        /**
         * Redirect kembali ke halaman COA
         * dengan pesan sukses
         */
        return redirect('/coas')
            ->with('success', 'COA created');
    }

    /**
     * Menampilkan detail COA berdasarkan id
     */
    public function show($id)
    {
        /**
         * Cari COA berdasarkan id
         * beserta relasi category
         * 
         * findOrFail():
         * - jika data ada => return data
         * - jika tidak ada => otomatis error 404
         */
        $coa = Coa::with('category')->findOrFail($id);

        /**
         * Return data COA dalam bentuk JSON
         */
        return response()->json($coa);
    }

    /**
     * Update data COA
     */
    public function update(Request $request, $id)
    {
        /**
         * Cari data COA berdasarkan id
         */
        $coa = Coa::findOrFail($id);

        /**
         * Update data COA
         */
        $coa->update([

            // Update kode akun
            'code' => $request->code,

            // Update nama akun
            'name' => $request->name,

            // Update category
            'category_id' => $request->category_id
        ]);

        /**
         * Redirect kembali ke halaman COA
         * dengan flash message sukses
         */
        return redirect('/coas')
            ->with('success', 'COA updated');
    }

    /**
     * Hapus data COA
     */
    public function destroy($id)
    {
        /**
         * Cari COA berdasarkan id
         */
        $coa = Coa::findOrFail($id);

        /**
         * Hapus data dari database
         */
        $coa->delete();

        /**
         * Redirect kembali dengan pesan sukses
         */
        return redirect('/coas')
            ->with('success', 'COA deleted');
    }

    /**
     * Menampilkan halaman view COA
     */
    public function view()
    {
        /**
         * Ambil semua data COA
         * beserta relasi category
         */
        $coas = Coa::with('category')
            ->latest()
            ->get();

        /**
         * Ambil semua category
         * untuk dropdown/select form
         */
        $categories = Category::latest()->get();

        /**
         * Tampilkan halaman:
         * dashboard.sections.coas
         * 
         * compact():
         * mengirim variabel ke view
         */
        return view(
            'dashboard.sections.coas',
            compact('coas', 'categories')
        );
    }
}