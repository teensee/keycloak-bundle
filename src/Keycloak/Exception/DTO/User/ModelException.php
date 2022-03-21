<?php

namespace KeycloakBundle\Keycloak\Exception\DTO\User;

use Exception;

final class ModelException extends Exception
{
    public static function invalidEmail(string $value): ModelException
    {
        return new ModelException("Incorrect email: {$value} passed", 400);
    }

    public static function invalidUuid(string $id): ModelException
    {
        return new ModelException("Invalid uuid: {$id} passed", 400);
    }
}