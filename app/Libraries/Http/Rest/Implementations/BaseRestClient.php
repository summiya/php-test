<?php

namespace App\Libraries\Http\Rest\Implementations;

use App\Libraries\Http\Rest\IExceptionHandler;
use App\Libraries\Http\Rest\IResponseHandler;
use App\Libraries\Http\Rest\IRestClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class BaseRestClient extends Client implements IRestClient {

    protected ?IExceptionHandler $exceptionHandler;
    protected ?IResponseHandler $responseHandler;

    protected array $defaultHeaders = [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]
    ];

    /**
     * @param $uri
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get($uri, array $options = []) :ResponseInterface {

        if (!empty($query)) {
            $query = [
                'query' => $query
            ];
        }

        try {
            $response = $this->request(
                'GET',
                $uri,
                array_merge_recursive(
                    $this->defaultHeaders,
                    $options
                )
            );

            return $response;

        } catch (GuzzleException $exception) {
            return $this->handleException($exception);
        }

    }


    public function setResponseHandler(IResponseHandler $responseHandler) {
        $this->responseHandler = $responseHandler;
    }

    public function getResponseHandler() : ?IResponseHandler {
        return $this->responseHandler;
    }

    protected function handleResponse(ResponseInterface $response): ResponseInterface {

        $handler = $this->getResponseHandler();

        if (!is_null($handler)) {
            return $handler->handleResponse($response);
        } else {
            return $response;
        }
    }

    public function setExceptionHandler(IExceptionHandler $exceptionHandler) {
        $this->exceptionHandler = $exceptionHandler;
    }

    protected function getExceptionHandler() : ?IExceptionHandler {
        return $this->exceptionHandler;
    }

    protected function handleException(GuzzleException $exception) {

        $handler = $this->getExceptionHandler();

        if (!is_null($handler)) {

            if ($exception instanceof RequestException) {
                $exception->getRequest()->getBody()->rewind(); // The request body is a stream, it might need rewinding :/ (https://github.com/8p/EightPointsGuzzleBundle/issues/48)
            }

            return $handler->handleException($exception);
        } else {
            throw $exception;
        }

    }

    public function rawRequest(string $method, string $url, array $options) : ResponseInterface {
        return $this->request(
            $method,
            $url,
            $options
        );
    }

    public function getDefaultHeaders() : array {
        return $this->defaultHeaders;
    }

}
