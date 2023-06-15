<?php
namespace App\Libraries\Http\Exceptions;

use App\Libraries\Http\Rest\Response;

/*
 * This exception wraps a Response object
 */
class ResponseException extends \Exception {

    private Response $response;

    public function __construct(Response $response) {
        $this->response = $response;
        $description = $this->getDescription();
        parent::__construct($description, $response->getResultCode());
    }

    public function getResponse() : Response {
        return $this->response;
    }

    public function getResultCode(): int {
        return $this->getResponse()->getResultCode();
    }

    public function getResultMessage(): ?string {
        return $this->getResponse()->getMessage();
    }

    public function getResultData(): ?array {
        return $this->getResponse()->getData();
    }

    public function getServiceCode(): ?string {
        return $this->getResponse()->getServiceCode();
    }

    private function getDescription() : string {

        $serviceCode = $this->response->getServiceCode();
        $resultCode = $this->response->getResultCode();
        $message = $this->response->getMessage();

        $description = "{$serviceCode}-{$resultCode}";
        if (!is_null($message)) {
            $description .= ": {$message}";
        }

        return $description;

    }

}
