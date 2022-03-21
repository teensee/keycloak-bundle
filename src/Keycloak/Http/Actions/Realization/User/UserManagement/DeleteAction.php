<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Realization\User\UserManagement;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

class DeleteAction extends Action
{
    const ADDRESS_PATTERN = 'admin/realms/[REALM]/users/[ID]';

    public function __construct(private Uuid4 $id, private AccessToken $adminToken, private ConfigurationInterface $configuration)
    {

    }

    public function getUri(): string
    {
        return str_replace(
            ['[REALM]', '[ID]'],
            [$this->configuration->getRealm(), $this->id->getValue()],
            self::ADDRESS_PATTERN
        );
    }

    public function getMethod(): Method
    {
        return Method::DELETE;
    }

    public function getOptions(): array
    {
        return [
            'headers' => [
                'Authorization' => "Bearer {$this->adminToken->getToken()}",
                'Content-Type' => 'application/json',
            ]
        ];
    }
}