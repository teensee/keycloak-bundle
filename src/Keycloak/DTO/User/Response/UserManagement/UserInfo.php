<?php

namespace KeycloakBundle\Keycloak\DTO\User\Response\UserManagement;

use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Name;
use KeycloakBundle\Keycloak\DTO\Common\Username;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\Exception\DTO\User\DTOException;

final class UserInfo implements \JsonSerializable
{
    private function __construct(
        private Uuid4 $id,
        private Email|Username $username,
        private ?Email $email,
        private ?Name $name
    ) {

    }

    /**
     * @throws DTOException
     */
    public static function fromResponse(array $response): UserInfo
    {
        if (!isset($response['id'], $response['username'])) {
            throw DTOException::incorrectJsonPassed(self::class, __METHOD__, []);
        }

        return new UserInfo(
            Uuid4::fromString($response['id']),
            new Username('username'),
            $response['email'] !== null ? new Email($response['email']) : null,
            new Name('', '')
        );
    }

    /**
     * @return Uuid4
     */
    public function getId(): Uuid4
    {
        return $this->id;
    }

    /**
     * @return Email|Username
     */
    public function getUsername(): Email|Username
    {
        return $this->username;
    }

    /**
     * @return Email|null
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @return Name|null
     */
    public function getName(): ?Name
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [];
    }
}