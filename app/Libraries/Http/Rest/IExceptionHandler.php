<?php

namespace App\Libraries\Http\Rest;

use GuzzleHttp\Exception\GuzzleException;

interface IExceptionHandler {

    public function handleException(GuzzleException $exception);

}
