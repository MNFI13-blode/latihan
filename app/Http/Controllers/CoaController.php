<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Category;
use Illuminate\Http\Request;

// {{-- 
//     Digunakan untuk validasi unique
//     saat update data
// --}}
use Illuminate\Validation\Rule;

class CoaController extends Controller
{
    // =====================================================
    // MENAMPILKAN SEMUA DATA COA DALAM FORMAT JSON
    // =====================================================
    public function index()
    {
        /*
            Mengambil semua data COA
            beserta relasi category
            lalu diurutkan terbaru
        */
        $coas = Coa::with('category')
            ->latest()
            ->get();

        /*
            Mengembalikan data
            dalam format JSON
        */
        return response()->json($coas);
    }

    // =====================================================
    // MENYIMPAN DATA COA BARU
    // =====================================================
    public function store(Request $request)
    {
        /*
            Validasi input user
        */
        $request->validate([

            /*
                Code wajib diisi
                dan harus unique
                di tabel coas
            */
            'code' => 'required|unique:coas,code',

            /*
                Nama wajib diisi
            */
            'name' => 'required',

            /*
                Category wajib dipilih
            */
            'category_id' => 'required'

        ], [

            /*
                Custom pesan error
            */
            'code.unique' => 'Code COA sudah ada',

            'code.required' => 'Code wajib diisi'
        ]);

        /*
            Menyimpan data COA baru
        */
        Coa::create([

            'code' => $request->code,

            'name' => $request->name,

            'category_id' => $request->category_id
        ]);

        /*
            Redirect kembali
            ke halaman COA
        */
        return redirect('/coas')

            /*
                Membawa session success
            */
            ->with('success', 'COA created');
    }

    // =====================================================
    // MENAMPILKAN DETAIL COA BERDASARKAN ID
    // =====================================================
    public function show($id)
    {
        /*
            Cari COA berdasarkan ID
            beserta relasi category

            Jika tidak ditemukan,
            otomatis 404
        */
        $coa = Coa::with('category')
            ->findOrFail($id);

        /*
            Return data JSON
        */
        return response()->json($coa);
    }

    // =====================================================
    // UPDATE DATA COA
    // =====================================================
    public function update(Request $request, $id)
    {
        /*
            Cari data COA berdasarkan ID
        */
        $coa = Coa::findOrFail($id);

        /*
            Validasi input update
        */
        $request->validate([

            /*
                Code:
                - wajib diisi
                - unique
                - kecuali data dirinya sendiri
            */
            'code' => [

                'required',

                Rule::unique('coas', 'code')
                    ->ignore($coa->id)
            ],

            /*
                Nama wajib diisi
            */
            'name' => 'required',

            /*
                Category wajib dipilih
            */
            'category_id' => 'required'

        ], [

            /*
                Custom error
            */
            'code.unique' => 'Code COA sudah ada',
        ]);

        /*
            Update data COA
        */
        $coa->update([

            'code' => $request->code,

            'name' => $request->name,

            'category_id' => $request->category_id
        ]);

        /*
            Redirect kembali
            ke halaman COA
        */
        return redirect('/coas')

            ->with('success', 'COA updated');
    }

    // =====================================================
    // HAPUS DATA COA
    // =====================================================
    public function destroy($id)
    {
        /*
            Cari data COA
            berdasarkan ID
        */
        $coa = Coa::findOrFail($id);

        /*
            Hapus data
        */
        $coa->delete();

        /*
            Redirect kembali
            ke halaman COA
        */
        return redirect('/coas')

            ->with('success', 'COA deleted');
    }

    // =====================================================
    // MENAMPILKAN HALAMAN VIEW COA
    // =====================================================
    public function view(Request $request)
    {
        /*
            Query awal
            beserta relasi category
        */
        $query = Coa::with('category');

        // =================================================
        // FILTER SEARCH
        // =================================================
        
        if ($request->search) {

            /*
                Cari berdasarkan:
                - code
                - name
            */
            $query->where(function ($q) use ($request) {

                $q->where(
                    'code',
                    'like',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }

        // =================================================
        // FILTER CATEGORY
        // =================================================
        
        if ($request->category_id) {

            /*
                Filter berdasarkan category
            */
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        /*
            Ambil data terbaru
        */
        $coas = $query->latest()->get();

        /*
            Ambil semua category
            untuk dropdown filter
        */
        $categories = Category::latest()->get();

        /*
            Kirim data ke view blade
        */
        return view(
            'dashboard.sections.coas',

            compact(
                'coas',
                'categories'
            )
        );
    }
}