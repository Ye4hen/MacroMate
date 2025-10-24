<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @return array [$q, $per_page, $page]
     */
    protected function paginationParams(Request $request, int $default_per_page = 15): array
    {
        $q = (string) $request->query('q', '');
        $per_page = (int) $request->query('per_page', $default_per_page);

        if ($per_page <= 0) {
            $per_page = $default_per_page;
        }
        $page = (int)max(1, (int) $request->query('page', 1));

        return [$q, $per_page, $page];
    }

    protected function doSearch(
        Request $request,
        string $model_class,
        array $select,
        array $search_columns,
        ?callable $map = null,
        int $limit = 20
    ): JsonResponse {
        $q = trim((string)$request->query('q', ''));

        $base_query = $model_class::select($select)->orderBy($select[1] ?? $select[0]);

        if (mb_strlen($q) < 3) {
            $items = $base_query->limit($limit)->get();
        } else {
            $term = "%{$q}%";
            $items = (clone $base_query)
              ->where(function (Builder $w) use ($search_columns, $term) {
                  foreach ($search_columns as $col) {
                      $w->orWhere($col, 'like', $term);
                  }
              })
              ->limit($limit)
              ->get();
        }

        $results = $items->map(function ($item) use ($map) {
            return $map ? $map($item) : $item->toArray();
        })->values();

        return response()->json(['results' => $results]);
    }
}
