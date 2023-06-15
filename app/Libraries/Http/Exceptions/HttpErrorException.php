<?php

namespace App\Libraries\Http\Exceptions;

class HttpErrorException extends \Exception {

    protected $url;
    protected $method;
    protected $httpCode;

    /**
     * HttpErrorException constructor.
     * @param $url
     * @param $method
     * @param $httpCode
     */
    public function __construct($url, $method, $httpCode) {
        parent::__construct();
        $this->url = $url;
        $this->method = $method;
        $this->httpCode = $httpCode;
        $this->code = $httpCode;
    }

    /**
     * @return mixed
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

}
