<?php

use App\Http\Controllers\Web\{
    ActivityController,
    AdminActivityController,
    AdminFoodController,
    AdminPlanController,
    AdminUserController,
    AuthController,
    DashboardController,
    FoodController,
    GoogleAuthController,
    MealFoodController,
    ProfileController,
    UserActivitiesController
};
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/profile/account-settings');
Route::redirect('/profile', '/profile/account-settings');

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLogin')->name('login');
    Route::post('login', 'login')->name('login.post');

    Route::get('register', 'showRegister')->name('register');
    Route::post('register', 'register')->name('register.post');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// Health check endpoint for uptime monitoring (e.g. UptimeRobot)
Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::middleware('jwt')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile/account-settings', 'index')->name('profile');
        Route::get('profile/body-metrics', 'showBodyMetrics')->name('profile-body-metrics');
        Route::get('profile/plan', 'showPlan')->name('profile-plan');
        Route::get('profile/macros', 'showMacros')->name('profile-macros');
        Route::get('profile/macros/edit', 'showMacrosEdit')->name('profile-macros-edit');
        Route::get('profile/summary', 'showSummary')->name('profile-summary');
        Route::get('profile/summary/data', 'summaryData')->name('profile.summary.data');
        Route::patch('profile', 'update')->name('profile.update');
        Route::patch('profile-password', 'updatePassword')->name('profile.password.update');
        Route::patch('profile-macros', 'updateMacros')->name('profile.macros.update');
    });
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
    });
    Route::controller(MealFoodController::class)->group(function () {
        Route::post('meals/{meal}/foods', 'addFoods')->name('meals.foods.store');
        Route::post('meals', 'store')->name('meals.create');
        Route::patch('meals/{meal}/foods/{food}', 'updateFood')
          ->name('meals.foods.update');
        Route::delete('meals/{meal}/foods/{food}', 'removeFood')
          ->name('meals.foods.removeFood');
    });
    Route::get('meals/{meal}/foods/{food}/edit-modal', [MealFoodController::class, 'editModal'])
      ->name('meals.food.edit_modal');
    Route::get('foods/popup', [FoodController::class, 'popup'])->name('foods.popup');
    Route::get('foods/search', [FoodController::class, 'search'])->name('foods.search');
    Route::get('/foods/more', [FoodController::class, 'more'])->name('foods.more');
    Route::controller(UserActivitiesController::class)->group(function () {
        Route::post('user/activities/{activity}', 'addActivity')->name('user.activities.add');
        Route::patch('user/activities/{activity}', 'updateActivity')->name('user.activities.update');
        Route::delete('user/activities/{activity}', 'removeActivity')->name('user.activities.remove');
    });
    Route::get('activities/search', [ActivityController::class, 'search'])->name('activities.search');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin,sub_admin')->prefix('admin')->group(function () {
        Route::controller(AdminActivityController::class)->group(function () {
            Route::get('activities', 'index')->name('admin.activities.index');
            Route::get('activities/search', 'search')->name('admin.activities.search');
            Route::get('activities/create', 'create')->name('admin.activities.create');
            Route::post('activities', 'store')->name('admin.activities.store');
            Route::get('activities/{activity}/edit', 'edit')->name('admin.activities.edit');
            Route::patch('activities/{activity}', 'update')->name('admin.activities.update');
            Route::delete('activities/{activity}', 'destroy')->name('admin.activities.destroy');
        });
        Route::controller(AdminFoodController::class)->group(function () {
            Route::get('foods', 'index')->name('admin.foods.index');
            Route::get('foods/search', 'search')->name('admin.foods.search');
            Route::get('foods/create', 'create')->name('admin.foods.create');
            Route::post('foods', 'store')->name('admin.foods.store');
            Route::get('foods/{food}/edit', 'edit')->name('admin.foods.edit');
            Route::patch('foods/{food}', 'update')->name('admin.foods.update');
            Route::delete('foods/{food}', 'destroy')->name('admin.foods.destroy');
        });
        Route::controller(AdminPlanController::class)->group(function () {
            Route::get('plans', 'index')->name('admin.plans.index');
            Route::get('plans/create', 'create')->name('admin.plans.create');
            Route::post('plans', 'store')->name('admin.plans.store');
            Route::get('plans/{plan}/edit', 'edit')->name('admin.plans.edit');
            Route::patch('plans/{plan}', 'update')->name('admin.plans.update');
            Route::delete('plans/{plan}', 'destroy')->name('admin.plans.destroy');
        });
        Route::controller(AdminUserController::class)->group(function () {
            Route::get('users', 'index')->name('admin.users.index');
            Route::get('users/search', 'search')->name('admin.users.search');
            Route::get('users/{user_edit}/edit', 'edit')->name('admin.users.edit');
            Route::patch('users/{user_edit}', 'update')->name('admin.users.update');
            Route::delete('users/{user_edit}', 'destroy')->name('admin.users.destroy');
        });
    });
});

// temporary debug
Route::get('/debug/logs', function () {
    return nl2br(file_get_contents(storage_path('logs/laravel.log')));
});
