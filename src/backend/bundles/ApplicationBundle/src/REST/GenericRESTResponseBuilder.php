<?php
namespace Application\REST;

class GenericRESTResponseBuilder extends RESTResponseBuilder
{
    const CODE_SUCCESS = 200;
    const CODE_NOT_FOUND = 404;
    const CODE_NOT_ALLOWED = 403;

    public function setStatusSuccess(): self {
        $this->setStatus(self::CODE_SUCCESS);

        return $this;
    }

    public function setStatusNotFound(): self {
        $this->setStatus(self::CODE_NOT_FOUND);

        return $this;
    }

    public function setStatusNotAllowed(): self {
        $this->setStatus(self::CODE_NOT_ALLOWED);

        return $this;
    }

    public function isSuccess(): bool
    {
        return $this->getStatus() === self::CODE_SUCCESS;
    }
}