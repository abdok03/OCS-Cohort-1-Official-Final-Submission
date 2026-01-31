<?php

namespace App\Providers;

use App\Http\Livewire\AvatarUpload;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('avatar-upload', AvatarUpload::class);
        Paginator::useBootstrapFive();
    }
}
