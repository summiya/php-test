<?php

namespace App\Libraries\Http\Rest\Implementations;

use App\Libraries\Http\Rest\IResponseHandler;
use Psr\Http\Message\ResponseInterface;

class JsonDecoderResponseHandler implements IResponseHandler {

    public function handleResponse(ResponseInterface $response) {

        $body = $response->getBody()->getContents();
        $json = json_decode($body, true);

        return $json;
    }

}
