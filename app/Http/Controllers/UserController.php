<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserSyncService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // ================= BASE QUERY =================
        $query = User::query();

        // ================= SEARCH =================
        if ($request->search) {
            $search = $request->search;

            // Cari di beberapa kolom
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        // ================= SORTING =================
        $sort = $request->get('sort', 'updated_at'); // default sort
        $direction = $request->get('direction', 'desc'); // default desc

        $query->orderBy($sort, $direction);

        // ================= LIMIT DATA =================
        // Ambil max 50 data dari database
        $limited = $query->take(50)->get();

        // ================= PAGINATION MANUAL =================
        $perPage = 10;
        $currentPage = $request->get('page', 1);

        // Bagi data manual (karena sudah di-limit)
        $users = new LengthAwarePaginator(
            $limited->forPage($currentPage, $perPage), // slice data
            $limited->count(), // total data
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        // ================= LAST SYNC =================
        $lastSync = User::max('last_synced_at');

        // ================= RETURN VIEW =================
        return view('data', compact('users', 'lastSync'));
    }

    public function sync(UserSyncService $service)
    {
        // Panggil service (best practice 👍)
        $result = $service->sync();

        return response()->json([
            'message' => 'Sync berhasil',
            'data' => $result
        ]);
    }
}