<?php

namespace App\Http\Controllers\Web;

use App\Domain\Models\Food;
use App\Domain\Models\Meal;
use App\Enums\MealTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MealFoodController extends Controller
{
    public function addFoods(Request $request, Meal $meal): RedirectResponse
    {
        $data = $request->validate([
          'food_code' => 'required|string|exists:mm_foods,mf_code',
          'quantity' => 'nullable|numeric|min:0',
        ]);

        $food = Food::where('mf_code', $data['food_code'])->firstOrFail();
        $quantity = $data['quantity'] !== null ? (float)$data['quantity'] : 100;
        $unit = $food->mf_type->value === 'food' ? 'g' : 'ml';

        $existing = $meal->foods()->where('mf_id', $food->mf_id)->first();

        if ($existing) {
            $old_qty = (float)($existing->pivot->mmfr_quantity ?? 0);
            $new_qty = $old_qty + $quantity;
            $meal->foods()->updateExistingPivot($food->mf_id, [
              'mmfr_quantity' => $new_qty,
            ]);
        } else {
            $meal->foods()->attach($food->mf_id, [
              'mmfr_quantity' => $quantity,
              'mmfr_unit' => $unit,
            ]);
        }

        $user_code = $request->user()->mu_code;
        Cache::tags(['stats', "user:{$user_code}"])->flush();

        return redirect()->back()->with('success', 'Food added to meal.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
          'meal_type' => ['required', 'string'],
          'date' => ['required', 'date'],
          'food_code' => 'required|string|exists:mm_foods,mf_code',
          'quantity' => 'nullable|numeric|min:0',
          'unit' => 'nullable|string|max:20',
        ]);

        $user = $request->user();

        try {
            $meal_type_enum = MealTypeEnum::from($data['meal_type']);
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['meal_type' => 'Invalid meal type.']);
        }

        $next_order = (int) Meal::where('mm_user', $user->mu_code)
          ->whereDate('mm_date', $data['date'])
          ->max('mm_order');
        $next_order = $next_order ? $next_order + 1 : 1;

        $meal = new Meal();
        $meal->mm_code = 'm' . Str::random(8);
        $meal->mm_type = $meal_type_enum;
        $meal->mm_user = $user->mu_code;
        $meal->mm_order = $next_order;
        $meal->mm_date = $data['date'];
        $meal->save();

        $food = Food::where('mf_code', $data['food_code'])->firstOrFail();
        $quantity = $data['quantity'] !== null ? (float)$data['quantity'] : 100;
        $unit = $data['unit'] ?? ($food->mf_type->value === 'food' ? 'g' : 'ml');

        $meal->foods()->attach($food->mf_id, [
          'mmfr_quantity' => $quantity,
          'mmfr_unit' => $unit,
        ]);

        Cache::tags(['stats', "user:{$user->mu_code}"])->flush();

        return redirect()->back()->with('success', 'Meal created and food added.');
    }

    public function updateFood(Request $request, Meal $meal, Food $food): RedirectResponse
    {
        $data = $request->validate([
          'quantity' => 'required|numeric|min:0',
        ]);

        if ($meal->mm_user !== $request->user()->mu_code) {
            abort(403);
        }

        $meal->foods()->updateExistingPivot($food->mf_id, [
          'mmfr_quantity' => $data['quantity'],
        ]);

        $user_code = $request->user()->mu_code;
        Cache::tags(['stats', "user:{$user_code}"])->flush();

        return redirect()->back()->with('success', 'Food updated.');
    }

    public function removeFood(Request $request, Meal $meal, Food $food): RedirectResponse
    {
        $meal->foods()->detach($food->mf_id);

        if (!$meal->foods()->count()) {
            $meal->delete();
        }
        $user_code = $request->user()->mu_code;
        Cache::tags(['stats', "user:{$user_code}"])->flush();

        return redirect()->back()->with('success', 'Food removed from meal.');
    }

    public function editModal(Meal $meal, Food $food): View
    {
        return view('components.dashboard.food-edit-popup', [
          'meal' => $meal,
          'food' => $food,
        ]);
    }
}
