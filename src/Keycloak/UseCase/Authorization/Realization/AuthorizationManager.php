<?php

namespace KeycloakBundle\Keycloak\UseCase\Authorization\Realization;

use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\DTO\User\Response\Authorization\SuccessAuthorization;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Registration\SignUpRepositoryInterface;

class AuthorizationManager
{
    public function __construct(
        private AuthorizationRepositoryInterface $repository,
        private SignUpRepositoryInterface $signUpRepository
    ) {
    }

    public function login(UserCredentials $credentials): SuccessAuthorization
    {
        return $this->repository->login($credentials);
    }

    public function logout(TokenPairCredentials $credentials): void
    {
        $this->repository->logout($credentials);
    }

    public function refresh(RefreshToken $token): SuccessAuthorization
    {
        return $this->repository->refresh($token);
    }

    public function signUp(UserRepresentation $user)
    {
        $this->signUpRepository->signup($user);
        return true;
    }
}