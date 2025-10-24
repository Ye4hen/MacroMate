<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\StatsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailyStatsController extends Controller
{
    public function __construct(private readonly StatsService $stats)
    {
    }

    public function daily(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'user' => 'required|string|exists:mm_users,mu_code',
            'date' => 'required|date',
        ]);

        $totals = $this->stats->totalsForDate($data['user'], $data['date']);

        return response()->json([
            'date' => $data['date'],
            'totals' => $totals,
        ]);
    }

    public function range(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'user' => 'required|string|exists:mm_users,mu_code',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'group_by' => 'nullable|in:day,week,month',
        ]);

        $result = $this->stats->totalsForRange($data['user'], $data['from'], $data['to'], $data['group_by'] ?? 'day');

        return response()->json($result);
    }
}
