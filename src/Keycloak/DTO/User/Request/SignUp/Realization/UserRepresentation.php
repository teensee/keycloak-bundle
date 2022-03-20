<?php

namespace KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization;

use JsonSerializable;
use KeycloakBundle\Keycloak\DTO\Common\Collections\Abstraction\CollectionInterface;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Name;
use KeycloakBundle\Keycloak\DTO\Common\Username;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;

class UserRepresentation implements JsonSerializable
{
    public function __construct(
        private Uuid4 $id,
        private Username|Email $username,
        private Email $email,
        private CollectionInterface $credentials,
        private bool $enabled,
        private Name $name
    ) {
    }

    /**
     * @return Uuid4
     */
    public function getId(): Uuid4
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getUsername(): Email|Username
    {
        return $this->username;
    }

    /**
     * @return CollectionInterface
     */
    public function getCredentials(): CollectionInterface
    {
        return $this->credentials;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId()->getValue(),
            'username' => $this->getUsername()->getValue(),
            'email' => $this->getEmail()->getValue(),
            'credentials' => $this->getCredentials(),
            'firstName' => $this->getName()?->getFirstName(),
            'lastName' => $this->getName()?->getLastName(),
            'enabled' => $this->isEnabled()
        ];
    }
}