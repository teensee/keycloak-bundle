<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Realization\User\UserInfo;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

class GetIdAction extends Action
{
    const ADDRESS_PATTERN = 'admin/realms/[REALM]/users';

    public function __construct(
        private Email $email,
        private AccessToken $adminToken,
        private ConfigurationInterface $configuration
    ) {

    }

    public function getUri(): string
    {
        return str_replace('[REALM]', $this->configuration->getRealm(), self::ADDRESS_PATTERN);
    }

    public function getMethod(): Method
    {
        return Method::GET;
    }

    public function getOptions(): array
    {
        return [
            'headers' => [
                'Authorization' => "Bearer {$this->adminToken->getToken()}",
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'email' => $this->email->getValue(),
            ],
        ];
    }
}