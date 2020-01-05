<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeCategoryBar();
        View::composer('partials._nav','App\Http\View\Composers\NotificationComposer');
    }

    private function composeCategoryBar(){
        view()->composer('partials._categories',function($view){
            $view->with('_categories',Category::where('disabled',false)->get());
        });
    }
}
