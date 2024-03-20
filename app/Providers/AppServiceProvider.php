<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Blade::directive('datetime', function($expression) {
            return "<?php echo \App\Components\Helper::displayTime($expression); ?>";
        });

        Blade::directive('yesNoBadge', function($expression) {
            return "<?php echo \App\Components\Helper::printYesNoBadge($expression); ?>";
        });

        Blade::directive('amount', function($expression) {
            return "<?php echo \App\Constants\CommonConstants::CURRENCY_ICON.$expression; ?>";
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if(env('APP_HTTPS')){
            URL::forceScheme('https');
            // $this->app(['request']->server->set('HTTPS' , 'on'));
        }   

    }
}
