<?php

namespace KeycloakBundle\Keycloak\DTO\Token\Realization;

final class TokenPair
{
    public function __construct(private AccessToken $access, private ?RefreshToken $refresh)
    {
    }

    /**
     * @return AccessToken
     */
    public function getAccess(): AccessToken
    {
        return $this->access;
    }

    /**
     * @return RefreshToken|null
     */
    public function getRefresh(): ?RefreshToken
    {
        return $this->refresh;
    }
}