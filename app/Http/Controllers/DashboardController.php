<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function data(Request $request)
    {
        // ================= FILTER BY DATE =================
        // default 1 bulan terakhir
        $start = $request->start ?? Carbon::now()->subMonth();
        $end = $request->end ?? Carbon::now();

        // ================= BASE QUERY =================
        // limit 50 data terbaru berdasarkan created_at (untuk performa)
        $baseQuery = User::whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->limit(50);

        // ================= PIE CHART =================
        $pie = DB::table(DB::raw("({$baseQuery->toSql()}) as sub"))
            ->mergeBindings($baseQuery->getQuery())
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        // ================= BAR CHART =================
        $bar = DB::table(DB::raw("({$baseQuery->toSql()}) as sub"))
            ->mergeBindings($baseQuery->getQuery())
            ->select(
                DB::raw("
            CASE
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 0 AND 10 THEN '0-10'
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 11 AND 20 THEN '11-20'
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 AND 30 THEN '21-30'
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                ELSE '50+'
            END as age_range
        "),
                DB::raw('count(*) as total')
            )
            ->groupBy('age_range')
            ->orderBy('age_range')
            ->get();
        // ================= COUNTRY CHART =================
        $country = DB::table(DB::raw("({$baseQuery->toSql()}) as sub"))
            ->mergeBindings($baseQuery->getQuery())
            ->select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        // ================= LATEST DATA =================
        $latest = User::orderBy('updated_at', 'desc')
            ->limit(8)
            ->get(['first_name', 'last_name', 'email', 'updated_at']);

        // ================= RETURN JSON =================
        return response()->json([
            'pie' => [
                'labels' => $pie->keys(),
                'data' => $pie->values()
            ],
            'bar' => [
                'labels' => $bar->pluck('age_range'),
                'data' => $bar->pluck('total')
            ],
            'country' => [
                'labels' => $country->pluck('country'),
                'data' => $country->pluck('total')
            ],
            'latest' => $latest
        ]);
    }
}
