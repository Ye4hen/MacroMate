<?php

use App\Http\Controllers\Api\{
    ActivityController,
    AuthController,
    DailyStatsController,
    FoodController,
    MealController,
    PlanController,
    UserController,
    UserRoleController,
};
use Illuminate\Support\Facades\Route;

// Public routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Protected routes (requires JWT auth)
Route::middleware('jwt')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * Users
     * Accessible only to admin and sub_admin
     */
    Route::middleware('role:admin,sub_admin')->controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{user}', 'show');
        Route::post('/user', 'store');
        Route::patch('/users/{user}', 'update');
        Route::delete('/users/{user}', 'destroy');
    });

    Route::middleware('role:admin')->controller(UserController::class)->group(function () {
        Route::patch('/users/restore/{code}', 'restore');
    });

    /**
     * User roles
     * Read is public, modify requires JWT
     */
    Route::middleware('role:admin')->controller(UserRoleController::class)->group(function () {
        Route::get('/user-roles', 'index');
        Route::get('/user-roles/{user_role}', 'show');
        Route::post('/user-role', 'store');
        Route::patch('/user-roles/{user_role}', 'update');
        Route::delete('/user-roles/{user_role}', 'destroy');
    });

    Route::middleware('role:admin')->controller(UserRoleController::class)->group(function () {
        Route::patch('/user-roles/restore/{code}', 'restore');
    });

    /**
     * Plans
     * Modification accessible only to admin and sub_admin
     */
    Route::controller(PlanController::class)->group(function () {
        Route::get('/plans', 'index');
        Route::get('/plans/{plan}', 'show');
    });

    Route::middleware('role:admin,sub_admin')->controller(PlanController::class)->group(function () {
        Route::patch('/plans/{plan}', 'update');
        Route::post('/plan', 'store');
        Route::delete('/plans/{plan}', 'destroy');
    });

    Route::middleware('role:admin,sub_admin')->controller(PlanController::class)->group(function () {
        Route::patch('/plans/restore/{code}', 'restore');
    });

    /**
     * Activities
     * Modification accessible only to admin, sub_admin and premium_user
     */
    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities', 'index');
        Route::get('/activities/{activity}', 'show');
    });

    Route::middleware('role:admin,sub_admin,premium_user')->controller(ActivityController::class)->group(function () {
        Route::patch('/activities/{activity}', 'update');
        Route::post('/activity', 'store');
        Route::delete('/activities/{activity}', 'destroy');
    });

    Route::middleware('role:admin,sub_admin')->controller(ActivityController::class)->group(function () {
        Route::patch('/activities/restore/{code}', 'restore');
    });

    /**
     * Meals
     * Accessible to everyone
     */
    Route::controller(MealController::class)->group(function () {
        Route::get('/meals', 'index');
        Route::get('/meals/{meal}', 'show');
        Route::patch('/meals/{meal}', 'update');
        Route::post('/meal', 'store');
        Route::delete('/meals/{meal}', 'destroy');
    });

    Route::middleware('role:admin,sub_admin')->controller(MealController::class)->group(function () {
        Route::patch('/meals/restore/{code}', 'restore');
    });

    /**
     * Foods
     * Modification accessible only to admin, sub_admin and premium_user
     */
    Route::controller(FoodController::class)->group(function () {
        Route::get('/foods', 'index');
        Route::get('/foods/{food}', 'show');
    });

    Route::middleware('role:admin,sub_admin,premium_user')->controller(FoodController::class)->group(function () {
        Route::patch('/foods/{food}', 'update');
        Route::post('/food', 'store');
        Route::delete('/foods/{food}', 'destroy');
    });

    Route::middleware('role:admin,sub_admin')->controller(FoodController::class)->group(function () {
        Route::patch('/foods/restore/{code}', 'restore');
    });


    Route::controller(DailyStatsController::class)->group(function () {
        Route::get('/stats/daily', 'daily');
        Route::get('/stats/range', 'range');
    });
});

Route::fallback(fn () => response()->json(['message' => 'API endpoint not found'], 404));
