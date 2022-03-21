<?php

namespace KeycloakBundle\Keycloak\Exception\DTO\User;

use Exception;

final class UserDTOException extends Exception
{
    public static function incorrectJsonPassed(string $class, string $method, array $requiredFields): UserDTOException
    {
        $message = sprintf('%s::%s, expects fields: %s', $class, $method, implode(', ', $requiredFields));

        return new UserDTOException($message, 400);
    }
}