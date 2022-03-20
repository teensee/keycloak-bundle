<?php

namespace KeycloakBundle\Keycloak\Exception\Action;

use Exception;

final class ActionException extends Exception
{
    public static function incorrectCredentialObject(array $expected, string $passed): ActionException
    {
        $pattern = 'Expected %s, passed %s';
        $message = sprintf($pattern, implode(', ', $expected), $passed);

        return new ActionException($message, 400);
    }
}