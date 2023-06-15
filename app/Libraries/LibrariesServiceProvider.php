<?php

namespace App\Libraries;

use App\Libraries\Http\Rest\Implementations\BaseRestClient;
use App\Libraries\Http\Rest\IRestClient;
use App\Libraries\Notification\IEmailSender;
use App\Libraries\Notification\Implementations\MandrillService;
use Illuminate\Support\ServiceProvider;

class LibrariesServiceProvider extends ServiceProvider {

    public function register() {

        $this->app->bind(
            IRestClient::class,
            BaseRestClient::class
        );

        $this->app->bind(
            IEmailSender::class,
            MandrillService::class
        );
    }

}
