<?php

namespace App\Clients;

use App\Libraries\Http\Rest\IExceptionHandler;
use App\Libraries\Http\Rest\IRestClient;
use GuzzleHttp\Exception\GuzzleException;

class CompanySymbolClient {

    private IRestClient $restClient;
    private string $baseUrl;

    public function __construct(IRestClient $restClient, string $baseUrl) {
        $this->restClient = $restClient;
        $this->baseUrl = $baseUrl;

    }

    public function get(): array {

        $url = "/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json";

        $response = $this->restClient->get(
            $this->baseUrl . $url
        );

        return json_decode($response->getBody(), true);
    }

    protected function setHandlers() {

        $this->restClient->setExceptionHandler(new class implements IExceptionHandler {
            public function handleException(GuzzleException $exception) {

                $response = $exception->getResponse();

                if (!is_null($response)) {

                    $body = json_decode($response->getBody()->getContents(), true);

                    if (isset($body['code']) == 404) {
                        return null;
                    }

                }

                throw $exception;

            }

        });

    }

}
