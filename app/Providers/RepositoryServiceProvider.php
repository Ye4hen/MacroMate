<?php

namespace App\Providers;

use App\Contracts\{
    ActivityRepositoryInterface,
    FoodRepositoryInterface,
    MealRepositoryInterface,
    PlanRepositoryInterface,
    UserRepositoryInterface,
    UserRoleRepositoryInterface,
};
use App\Domain\Repositories\{
    ActivityRepository,
    FoodRepository,
    MealRepository,
    PlanRepository,
    UserRepository,
    UserRoleRepository,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserRoleRepositoryInterface::class, UserRoleRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(MealRepositoryInterface::class, MealRepository::class);
        $this->app->bind(FoodRepositoryInterface::class, FoodRepository::class);
    }
}
