<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Illuminate\Support\Facades;

class LanguageComposerServiceProvider extends ServiceProvider
{

    protected $language;
    public function __construct()
    {
        $this->language = new Language();
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // // Using class based composers...
        Facades\View::composer('*', function ($view) {
            $languages = $this->language->all();
            $view->with('languages', $languages);
        });
    }
}
