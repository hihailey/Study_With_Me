<?php

// namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

// class AppServiceProvider extends ServiceProvider
// {
//     /**
//      * Register any application services.
//      *
//      * @return void
//      */
//     public function register()
//     {
//         //
//     }

//     /**
//      * Bootstrap any application services.
//      *
//      * @return void
//      */
//     public function boot()
//     {
//         //
//     }
// }

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
  public function register()
  {
  }
  public function boot()
  {
    Schema::defaultStringLength(191);
    //  view()->composer('*', function ($view){
    view()->composer('*', function ($view) {
      if (Auth::check()) {
        $my_id = Auth::id();
        $group = user::find($my_id);
        $users = $group->group_member()->get();
        $view->with('users', $users);
      } else {
        $view->with('users', 0);
      }
    });
    view()->composer('*', function ($view) {
      $view->with('cartItem', 'asdrr');
    });
    // });
  }
}
