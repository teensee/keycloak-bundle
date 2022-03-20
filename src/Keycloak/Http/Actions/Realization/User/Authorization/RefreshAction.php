<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\Enum\GrantType;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

final class RefreshAction extends Action
{
    const ADDRESS_PATTERN = 'realms/[REALM]/protocol/openid-connect/token';

    public function __construct(private RefreshToken $token, private ConfigurationInterface $configuration)
    {
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
            'body' => [
                'client_id' => $this->configuration->getClientId(),
                'grant_type' => GrantType::REFRESH_TOKEN,
                'client_secret' => $this->configuration->getClientSecret(),
                'refresh_token' => $this->token->getToken(),
            ],
            'headers' => [
                "Content-Type" => "application/x-www-form-urlencoded",
            ],
        ];
    }
}