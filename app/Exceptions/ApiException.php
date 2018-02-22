<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class ApiException
 *
 * 一般来说，这个类不需要额外扩展，如果是需要增加新的错误码，只需要扩展 API_ERROR_CODE 中的错误码表即可。
 *
 * @package App\Exceptions
 */
class ApiException extends Exception
{
    protected $httpCode;
    protected $data;

    public function __construct(int $code, array $data = [], string $message = '')
    {
        if (array_key_exists($code, API_ERROR_CODE)) {
            $errorCode = API_ERROR_CODE[$code];
        } else {
            $errorCode = API_ERROR_CODE[1];
        }

        $this->httpCode = $errorCode[0];
        $this->data = $data;

        $message = $message ? $message : $errorCode[1];
        parent::__construct($message, $code);
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getData()
    {
        return $this->data;
    }

    public function report()
    {

    }
}
