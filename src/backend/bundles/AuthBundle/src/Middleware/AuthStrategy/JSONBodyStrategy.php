<?php
namespace Auth\Middleware\AuthStrategy;

use Auth\Exception\APIKeyIsNotAvailableException;

class JSONBodyStrategy extends Strategy
{
    public function isAPIKeyAvailable(): bool
    {
        $jsonBody = json_encode($this->request->getBody(), true);

        return isset($jsonBody['api_key']);
    }

    public function getAPIKey()
    {
        if(!$this->isAPIKeyAvailable()) {
            throw new APIKeyIsNotAvailableException;
        }

        $jsonBody = json_encode($this->request->getBody(), true);

        return isset($jsonBody['api_key']);
    }
}