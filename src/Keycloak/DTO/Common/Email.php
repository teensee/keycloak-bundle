<?php

namespace KeycloakBundle\Keycloak\DTO\Common;

use JsonSerializable;
use KeycloakBundle\Keycloak\Exception\DTO\User\ModelException;
use Stringable;

class Email implements JsonSerializable, Stringable
{
    private string $value;

    /**
     * @throws ModelException
     */
    public function __construct(string $email)
    {
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (false === $result) {
            throw ModelException::invalidEmail($email);
        }

        $this->value = $email;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->value,
        ];
    }
}