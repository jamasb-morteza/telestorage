<?php

namespace App\Providers;

use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\API;
use Illuminate\Support\ServiceProvider;

class MadelineProtoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /*$this->app->singleton(API::class, function () {
            $settings = (new AppInfo)
                ->setApiId(config('services.telegram.api_id'))
                ->setApiHash(config('services.telegram.api_hash'));

            return new API(storage_path('app/madeline/session.madeline'), $settings);
        });*/
    }
}
