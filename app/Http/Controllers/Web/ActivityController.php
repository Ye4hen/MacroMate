<?php

namespace App\Http\Controllers\Web;

use App\Domain\Models\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = trim((string)$request->query('q', ''));

        // default behavior: if q < 3 return the full set or a subset already loaded
        if (mb_strlen($q) < 3) {
            $activities = Activity::select('ma_code', 'ma_name', 'ma_cals')
                ->orderBy('ma_name')
                ->limit(30)
                ->get();
        } else {
            $term = "%{$q}%";
            $activities = Activity::select('ma_code', 'ma_name', 'ma_cals')
                ->where(function ($w) use ($term) {
                    $w->where('ma_name', 'like', $term);
                })
                ->orderBy('ma_name')
                ->limit(30)
                ->get();
        }

        $html = view('components.dashboard.activity-grid', compact('activities'))->render();

        return response()->json(['html' => $html]);
    }
}
