<?php

namespace App\Providers;

use App\Components\SMS\Contract\SMSInterface;
use App\Components\SMS\Providers\NullProvider;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('sms', function () {
            $provider = config('sms.providers.' . env('SMS_PROVIDER'));
            if ($provider) {
                $class = new $provider;
                if ($class instanceof SMSInterface) {
                    return $class;
                }
            }
            return new NullProvider;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Grammar::macro('typeNumeric', function ($column) {
            return 'numeric';
        });
    }
}
