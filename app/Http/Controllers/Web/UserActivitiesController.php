<?php

namespace App\Http\Controllers\Web;

use App\Domain\Models\Activity;
use App\Domain\Models\UserActivity;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserActivitiesController extends Controller
{
    public function addActivity(Request $request, Activity $activity): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
          'date' => 'required|date',
          'time_spent' => 'required|numeric|min:1',
        ]);

        $user = $request->user();
        $calories_burned = round($activity->ma_cals * ($data['time_spent'] / 60));

        $existing_activity = UserActivity::where('mu_id', $user->mu_id)
          ->where('ma_id', $activity->ma_id)
          ->whereDate('mua_date', $data['date'])
          ->first();

        if (!$existing_activity) {
            $user->activities()->create([
              'ma_id' => $activity->ma_id,
              'mua_date' => $data['date'],
              'mua_time' => $data['time_spent'],
              'mua_calories_burned' => $calories_burned,
            ]);
        }

        Cache::tags(['stats', "user:{$user->mu_code}"])->flush();

        return redirect()->back()->with('success', 'Activity added.');
    }

    public function updateActivity(Request $request, Activity $activity): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
          'date' => 'required|date',
          'time_spent' => 'required|numeric|min:1',
        ]);

        $user = $request->user();
        $date = Carbon::parse($data['date'])->format('Y-m-d');

        $user_activity = UserActivity::where('mu_id', $user->mu_id)
          ->where('ma_id', $activity->ma_id)
          ->whereDate('mua_date', $date)
          ->first();

        if (!$user_activity) {
            return redirect()->back()->withErrors(['not_found' => 'Activity record not found for the given date.']);
        }

        $calories_burned = (int) round($activity->ma_cals * ($data['time_spent'] / 60));

        $user_activity->update([
          'mua_time' => $data['time_spent'],
          'mua_calories_burned' => $calories_burned,
        ]);

        Cache::tags(['stats', "user:{$user->mu_code}"])->flush();

        return redirect()->back()->with('success', 'Activity updated.');
    }

    public function removeActivity(Request $request, Activity $activity): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
          'date' => 'required|date',
        ]);

        $user = $request->user();
        $date = Carbon::parse($data['date'])->format('Y-m-d');

        $user_activity = UserActivity::where('mu_id', $user->mu_id)
          ->where('ma_id', $activity->ma_id)
          ->whereDate('mua_date', $date)
          ->first();

        if (!$user_activity) {
            return redirect()->back()->withErrors(['not_found' => 'Activity record not found for the given date.']);
        }

        $user_activity->delete();

        Cache::tags(['stats', "user:{$user->mu_code}"])->flush();

        return redirect()->back()->with('success', 'Activity removed.');
    }
}
