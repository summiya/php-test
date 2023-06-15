<?php

namespace App\Providers;

use App\Clients\CompanySymbolClient;
use App\Clients\RapidApiClient;
use App\Libraries\Http\Rest\IRestClient;
use App\Libraries\Notification\IEmailSender;
use App\Libraries\Notification\Implementations\MandrillService;
use App\Libraries\Notification\NotificationService;
use App\Services\CompanySymbolService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {

        $this->registerThirdParties();

        $this->registerLocalServices();

    }

    private function registerThirdParties() {


        $this->app->singleton(RapidApiClient::class, function ($app) {
            return new RapidApiClient(
                app(IRestClient::class),
                env('RAPID_API_BASE_URL'),
                env('RAPID_API_SECRET_KEY')
            );
        });

        $this->app->singleton(MandrillService::class, function ($app) {
            return new MandrillService(
                new \Mandrill(env('MANDRILL_API_KEY'))
            );
        });

        $this->app->singleton(CompanySymbolClient::class, function ($app) {
            return new CompanySymbolClient(
                app(IRestClient::class),
                env('COMPANY_SYMBOL_BASE_URL')
            );
        });

    }

    private function registerLocalServices() {

        $this->app->bind(CompanySymbolService::class, function ($app) {
            return new CompanySymbolService(
                app(RapidApiClient::class),
                app(CompanySymbolClient::class)
            );
        });

        $this->app->bind(NotificationService::class, function ($app) {
            return new NotificationService(
                app(IEmailSender::class)
            );
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
