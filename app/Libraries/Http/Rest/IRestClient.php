<?php

namespace App\Libraries\Http\Rest;

use App\Libraries\Http\Exceptions\HttpErrorException;
use Psr\Http\Message\ResponseInterface;

interface IRestClient {

    /**
     * @param $uri
     * @param array $options
     * @return ResponseInterface
     * @throws HttpErrorException
     */
    public function get($uri, array $options = []) :ResponseInterface;

    public function setExceptionHandler(IExceptionHandler $exceptionHandler);

    public function setResponseHandler(IResponseHandler $responseHandler);

}
