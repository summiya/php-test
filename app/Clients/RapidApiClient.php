<?php

namespace App\Clients;

use App\Libraries\Http\Rest\IExceptionHandler;
use App\Libraries\Http\Rest\Implementations\JsonDecoderResponseHandler;
use App\Libraries\Http\Rest\IRestClient;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;

class RapidApiClient {

    private IRestClient $restClient;
    private string $baseUrl;
    private string $secretKey;
    protected array $defaultOptions = [];

    public function __construct(IRestClient $restClient, string $baseUrl, string $secretKey) {
        $this->restClient = $restClient;
        $this->baseUrl = $baseUrl;
        $this->secretKey = $secretKey;
        $this->restClient->setResponseHandler(new JsonDecoderResponseHandler());

        $this->setHandlers();

    }

    #[ArrayShape(['X-RapidAPI-Key' => "string", 'X-RapidAPI-Host' => "string"])] private function getHeaders(): array {

        return [
            'X-RapidAPI-Key' => $this->secretKey,
            'X-RapidAPI-Host' => $this->baseUrl
        ];

    }

    public function getHistoricalData(string $symbol, ?string $region = "US"): \stdClass {

        $url = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol={$symbol}&region={$region}";

        $response = $this->restClient->get(
            $url,
            [
                'headers' => $this->getHeaders()
            ]
        );

        return json_decode($response->getBody()->getContents());
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
