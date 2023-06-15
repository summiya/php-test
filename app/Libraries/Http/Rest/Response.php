<?php

namespace App\Libraries\Http\Rest;

use App\Libraries\Http\Exceptions\ResponseException;

class Response {

    const RESULT_TYPE_SUCCESS = 'SUCCESS';
    const RESULT_TYPE_PREDICTABLE = 'PREDICTABLE';
    const RESULT_TYPE_UNAVAILABLE = 'UNAVAILABLE';
    const RESULT_TYPE_INVALID_REQUEST = 'INVALID_REQUEST';
    const RESULT_TYPE_UNEXPECTED_ERROR = 'UNEXPECTED_ERROR';

    const RESULT_CODE_SUCCESS = 0;

    private ?string $serviceCode;
    private int $resultCode;
    private string $resultType;
    private ?string $message;
    private ?array $data;

    public function __construct(int $resultCode = 0, string $message = null, array $data = null, string $serviceCode = null) {
        $this->serviceCode = $serviceCode ?? $this->getDefaultServiceCode($serviceCode);
        $this->resultCode = $resultCode;
        $this->resultType = self::composeResultType($resultCode);
        $this->message = $message;
        $this->data = $data;
    }

    /**
     *
     * To throw a ResponseException from anywhere in the application, including when we receive an exception from another service
     *
     * @param int $resultCode
     * @param string|null $message
     * @param array|null $data
     * @param string|null $serviceCode
     * @throws ResponseException
     */
    public static function exception(int $resultCode = 0, string $message = null, array $data = null, string $serviceCode = null) {

        $response = new self(
            $resultCode,
            $message,
            $data,
            $serviceCode
        );

        throw new ResponseException($response);

    }

    /**
     *
     * To throw a ResponseException from a Response received from another project
     *
     * @param Response $response
     * @throws ResponseException
     */
    public static function escalate(Response $response) {
        throw new ResponseException($response);
    }

    /**
     *
     * To compose a response json, used from the controllers, and from the ExceptionHandler
     *
     * @param int $resultCode
     * @param string|null $message
     * @param array|null $resultData
     * @param string|null $serviceCode
     * @return array
     */
    public static function getJsonResponse(int $resultCode = 0, ?string $message = null, array $resultData = null, string $serviceCode = null, bool $defaultDataArray = false) : array {

        $responseData = [];

        // <legacy>
        if (is_null($resultData) || empty($resultData)) {
            $responseData['data'] = new \stdClass();
        }
        if ($resultCode == self::RESULT_CODE_SUCCESS) {
            $responseData['status'] = true;
        } else {
            $responseData['status'] = false;
            $responseData['error'] = [
                'code' => $resultCode,
                'message' => $message
            ];
        }
        // </legacy>

        $serviceCode = self::getDefaultServiceCode($serviceCode);
        $responseData['result'] = "$serviceCode-$resultCode";

        if (!is_null($message) && !empty($message)) {
            $responseData['message'] = $message;
        }

        if (!is_null($resultData) && !empty($resultData)) {
            $responseData['data'] = $resultData;
        } else if ($defaultDataArray) { // If data is empty, and the default data should be an array
            $responseData['data'] = [];
        }

        return $responseData;

    }

    public function getServiceCode(): string {
        return $this->serviceCode;
    }

    public function getResultCode(): int {
        return $this->resultCode;
    }

    public function getResultType(): string {
        return $this->resultType;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function getData(bool $checkForSuccess = false): ?array {

        if ($checkForSuccess) {
            $this->escalateOnNonSuccess();
        }

        return $this->data;
    }

    public function setData(?array $data) : self {
        $this->data = $data;
        return $this;
    }

    public function escalateOnNonSuccess() {

        if (!$this->isSuccess()) {
            self::escalate($this);
        }

    }

    public function isResult(string $serviceCode, int $resultCode) {
        return ($serviceCode == $this->serviceCode && $resultCode == $this->resultCode);
    }

    public function isAcceptable() : bool {
        return ($this->getResultType() == self::RESULT_TYPE_SUCCESS || $this->getResultType() == self::RESULT_TYPE_PREDICTABLE);
    }

    public function isSuccess() : bool {
        return $this->getResultType() == self::RESULT_TYPE_SUCCESS;
    }

    public function isUnavailable() : bool {
        return $this->getResultType() == self::RESULT_TYPE_UNAVAILABLE;
    }

    public function isInvalidRequest() : bool {
        return $this->getResultType() == self::RESULT_TYPE_INVALID_REQUEST;
    }

    public function isUnexpectedError() : bool {
        return $this->getResultType() == self::RESULT_TYPE_UNEXPECTED_ERROR;
    }

    /**
     *
     * Compare the project code of the response with the project code of the current project
     * If they are different, it's an upstream response (received from another project)
     *
     * @return bool
     */
    public function isUpstream() : bool {
        return $this->getServiceCode() != self::getDefaultServiceCode(null);
    }

    public static function composeResultType(int $resultCode) : string {

        if ($resultCode == self::RESULT_CODE_SUCCESS) {
            return self::RESULT_TYPE_SUCCESS;
        } else if ($resultCode >= 1 && $resultCode <= 299) {
            return self::RESULT_TYPE_PREDICTABLE;
        } else if ($resultCode >= 300 && $resultCode <= 399) {
            return self::RESULT_TYPE_UNAVAILABLE;
        } else if ($resultCode >= 400 && $resultCode <= 499) {
            return self::RESULT_TYPE_INVALID_REQUEST;
        } else {
            return self::RESULT_TYPE_UNEXPECTED_ERROR;
        }

    }

    public static function getDefaultServiceCode(?string $serviceCode = null) : string {

        if (!is_null($serviceCode)) {
            return $serviceCode;
        }

        // If no code is provided, we assume the response is originating in the current project, so we get the name from configuration
        $serviceCode = env('APP_NAME');

        // If there is no APP_NAME, or it's irrelevant (e.g. "localhost"), we say "unknown"
        if (is_null($serviceCode) || empty($serviceCode) || $serviceCode == 'localhost') {
            $serviceCode = 'unknown';
        }

        return strtoupper(substr($serviceCode, 0, 3));

    }

}
