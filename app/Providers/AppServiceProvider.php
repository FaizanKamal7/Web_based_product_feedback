<?php

namespace App\Providers;

use App\Enums\ReactionTypeEnum;
use App\Interfaces\FeedbackInterface;
use App\Repositories\FeedbackRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FeedbackInterface::class, FeedbackRepository::class);
        // Binding an enum to all views
        View::composer('*', function ($view) {
            $view->with('reactionTypeEnum', ReactionTypeEnum::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
