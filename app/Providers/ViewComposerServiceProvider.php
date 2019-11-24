<?php

namespace App\Providers;

use App\Category;
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
    }

    private function composeCategoryBar(){
        view()->composer('partials._categories',function($view){
            $view->with('_categories',Category::where('disabled',false)->get());
        });
    }
}
