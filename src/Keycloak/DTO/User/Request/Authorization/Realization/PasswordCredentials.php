<?php

namespace KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization;

use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\Enum\GrantType;

class PasswordCredentials extends UserCredentials
{
    public function __construct(private string $email, private string $password)
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->getEmail(),
            'password' => $this->getPassword(),
            'grant_type' => $this->getGrantType()->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function getGrantType(): GrantType
    {
        return GrantType::PASSWORD;
    }
}