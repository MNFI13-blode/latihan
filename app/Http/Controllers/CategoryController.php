<?php

namespace App\Http\Controllers;

// Import model Category
use App\Models\Category;

// Import Request untuk mengambil data dari form/input user
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua data category
     */
    public function index()
    {
        /**
         * Ambil semua category
         * latest() = urut berdasarkan created_at terbaru
         * get()    = eksekusi query dan ambil semua data
         */
        $categories = Category::latest()->get();

        /**
         * Return data dalam bentuk JSON
         * Biasanya dipakai untuk API / AJAX
         */
        return response()->json($categories);
    }

    /**
     * Menyimpan data category baru
     */
    public function store(Request $request)
    {
        /**
         * Insert data baru ke database
         * 
         * $request->name
         * mengambil input bernama "name"
         */
        Category::create([
            'name' => $request->name
        ]);

        /**
         * Setelah berhasil:
         * - redirect ke halaman /categories
         * - kirim flash message success
         */
        return redirect('/categories')
            ->with('success', 'Category created');
    }

    /**
     * Menampilkan detail category berdasarkan ID
     */
    public function show($id)
    {
        /**
         * Cari category berdasarkan id
         * 
         * findOrFail():
         * - kalau data ada => dikembalikan
         * - kalau tidak ada => otomatis 404
         */
        $category = Category::findOrFail($id);

        /**
         * Return data category dalam bentuk JSON
         */
        return response()->json($category);
    }

    /**
     * Update data category
     */
    public function update(Request $request, $id)
    {
        /**
         * Cari category berdasarkan id
         */
        $category = Category::findOrFail($id);

        /**
         * Update field name
         * dengan input dari request
         */
        $category->update([
            'name' => $request->name
        ]);

        /**
         * Redirect kembali ke halaman categories
         * sambil membawa pesan sukses
         */
        return redirect('/categories')
            ->with('success', 'Category updated');
    }

    /**
     * Hapus data category
     */
    public function destroy($id)
    {
        /**
         * Cari category berdasarkan id
         */
        $category = Category::findOrFail($id);

        /**
         * Hapus data dari database
         */
        $category->delete();

        /**
         * Redirect kembali dengan flash message
         */
        return redirect('/categories')
            ->with('success', 'Category deleted');
    }
    
    /**
     * Menampilkan halaman view categories
     */
    public function view()
    {
        /**
         * Ambil semua category terbaru
         */
        $categories = Category::latest()->get();

        /**
         * Tampilkan file view:
         * dashboard.sections.categories
         * 
         * compact('categories')
         * mengirim variabel $categories ke view
         */
        return view('dashboard.sections.categories', compact('categories'));
    }
}