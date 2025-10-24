<?php

namespace App\Http\Controllers\Web;

use App\Domain\Models\Food;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = trim((string)$request->query('q', ''));

        if (mb_strlen($q) < 3) {
            $available_foods = Food::select('mf_code', 'mf_name', 'mf_type', 'mf_cals', 'mf_image_url')
              ->orderBy('mf_name')
              ->limit(30)
              ->get();
        } else {
            $term = "%{$q}%";
            $available_foods = Food::select('mf_code', 'mf_name', 'mf_type', 'mf_cals', 'mf_image_url')
              ->where(function ($w) use ($term) {
                  $w->where('mf_name', 'like', $term)
                    ->orWhere('mf_type', 'like', $term);
              })
              ->orderBy('mf_name')
              ->limit(30)
              ->get();
        }

        $html = view('components.dashboard.food-grid', compact('available_foods'))->render();

        return response()->json(['html' => $html]);
    }

    public function more(Request $request): View
    {
        $page = max(1, (int)$request->query('page', 2));
        $per_page = 30;
        $offset = ($page - 1) * $per_page;

        $foods = Food::select('mf_code', 'mf_name', 'mf_type', 'mf_cals', 'mf_image_url')
          ->orderBy('mf_name')
          ->skip($offset)
          ->take($per_page)
          ->get();

        $is_last = $foods->count() < $per_page;

        return view('components.dashboard.food-cards', compact('foods', 'page', 'is_last'));
    }

    public function popup(Request $request): View
    {
        $meal_code = $request->query('meal', null);
        $meal_type = $request->query('meal_type', null);
        $date = $request->query('date', now()->toDateString());

        $available_foods = Food::select('mf_code', 'mf_name', 'mf_type', 'mf_cals', 'mf_image_url')
          ->orderBy('mf_name')
          ->limit(30)
          ->get();

        return view('components.dashboard.foods-popup', compact('available_foods', 'meal_code', 'meal_type', 'date'))->with('show', true);
    }
}
