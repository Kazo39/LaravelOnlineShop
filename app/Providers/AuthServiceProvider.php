<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Addition;
use App\Models\Drink;
use App\Models\Food;
use App\Models\Order;
use App\Models\Other;
use App\Models\Snack;
use App\Policies\AdditionPolicy;
use App\Policies\DrinkPolicy;
use App\Policies\FoodPolicy;
use App\Policies\OrderPolicy;
use App\Policies\OtherPolicy;
use App\Policies\SnackPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Food::class => FoodPolicy::class,
        Drink::class => DrinkPolicy::class,
        Snack::class => SnackPolicy::class,
        Other::class => OtherPolicy::class,
        Addition::class => AdditionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
