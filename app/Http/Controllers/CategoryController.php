<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua data category dalam bentuk JSON
     */
    public function index()
    {
        // Ambil semua category dari database
        // latest() = urut berdasarkan data terbaru
        $categories = Category::latest()->get();

        // Kembalikan data dalam format JSON
        return response()->json($categories);
    }

    /**
     * Menyimpan data category baru
     */
    public function store(Request $request)
    {
        // Membuat data category baru
        // value name diambil dari input form/request
        Category::create([
            'name' => $request->name
        ]);

        // Setelah berhasil simpan,
        // redirect kembali ke halaman categories
        // sambil membawa pesan success
        return redirect('/categories')
            ->with('success', 'Category created');
    }

    /**
     * Menampilkan 1 data category berdasarkan id
     */
    public function show($id)
    {
        // Cari category berdasarkan id
        // jika tidak ditemukan -> otomatis error 404
        $category = Category::findOrFail($id);

        // Kembalikan data dalam format JSON
        return response()->json($category);
    }

    /**
     * Mengupdate data category
     */
    public function update(Request $request, $id)
    {
        // Cari category berdasarkan id
        $category = Category::findOrFail($id);

        // Update data name
        $category->update([
            'name' => $request->name
        ]);

        // Redirect kembali ke halaman categories
        // dengan pesan success
        return redirect('/categories')
            ->with('success', 'Category updated');
    }

    /**
     * Menghapus data category
     */
    public function destroy($id)
    {
        // Cari category berdasarkan id
        $category = Category::findOrFail($id);

        // Hapus data
        $category->delete();

        // Redirect kembali ke halaman categories
        // dengan pesan success
        return redirect('/categories')
            ->with('success', 'Category deleted');
    }

    /**
     * Menampilkan halaman categories
     * beserta fitur search & filter tanggal
     */
    public function view(Request $request)
    {
        // Membuat query awal dari model Category
        $query = Category::query();

        /**
         * FILTER SEARCH
         * Jika ada input search,
         * cari category berdasarkan nama
         */
        if ($request->search) {

            // SQL:
            // WHERE name LIKE '%keyword%'
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        /**
         * FILTER START DATE
         * Jika start_date diisi,
         * ambil data dari tanggal tersebut ke atas
         */
        if ($request->start_date) {

            // WHERE created_at >= start_date
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        /**
         * FILTER END DATE
         * Jika end_date diisi,
         * ambil data sampai tanggal tersebut
         */
        if ($request->end_date) {

            // WHERE created_at <= end_date
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Ambil hasil query
        // latest() = urut dari terbaru
        $categories = $query->latest()->get();

        // Kirim data categories ke blade view
        return view('dashboard.sections.categories', compact('categories'));
    }
}