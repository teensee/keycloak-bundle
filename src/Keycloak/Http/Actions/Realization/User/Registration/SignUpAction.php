<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Realization\User\Registration;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

final class SignUpAction extends Action
{
    const ADDRESS_PATTERN = '/admin/realms/[REALM]/users';

    public function __construct(
        private UserRepresentation $user,
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
        return Method::POST;
    }

    public function getOptions(): array
    {
        return [
            'headers' => [
                "Authorization" => "Bearer {$this->adminToken->getToken()}",
                'Content-Type' => 'application/json',
            ],
            'json' => $this->getJson(),
        ];
    }

    private function getJson(): string
    {
        return json_encode($this->user);
    }
}