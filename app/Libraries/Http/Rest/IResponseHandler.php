<?php

namespace App\Libraries\Http\Rest;

use Psr\Http\Message\ResponseInterface;

interface IResponseHandler {

    public function handleResponse(ResponseInterface $response);

}
