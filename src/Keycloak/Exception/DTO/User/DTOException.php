<?php

namespace KeycloakBundle\Keycloak\Exception\DTO\User;

use Exception;

final class DTOException extends Exception
{
    public static function incorrectJsonPassed(string $class, string $method, array $requiredFields): DTOException
    {
        $message = sprintf('%s::%s, expects fields: %s', $class, $method, implode(', ', $requiredFields));

        return new DTOException($message, 400);
    }
}