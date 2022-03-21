<?php

namespace KeycloakBundle\Keycloak\Exception\Repository;

use Exception;

final class InvalidJsonException extends Exception
{
    public static function fromError(int $errorCode, string $errorMessage): InvalidJsonException
    {
        return new InvalidJsonException("code: {$errorCode}, message: {$errorMessage}");
    }
}