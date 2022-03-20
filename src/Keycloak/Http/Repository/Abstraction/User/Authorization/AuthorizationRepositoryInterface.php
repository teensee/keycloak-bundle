<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization;

use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\DTO\User\Response\Authorization\SuccessAuthorization;

interface AuthorizationRepositoryInterface
{
    public function login(UserCredentials $credentials): SuccessAuthorization;

    public function logout(TokenPairCredentials $credentials): void;

    public function refresh(RefreshToken $token): SuccessAuthorization;
}