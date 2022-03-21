<?php

namespace KeycloakBundle\Keycloak\UseCase\Authorization\Realization;

use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\DTO\User\Response\Authorization\SuccessAuthorization;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Registration\SignUpRepositoryInterface;
use KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserInfo\UserInfoRepository;

class AuthorizationManager
{
    public function __construct(
        private AuthorizationRepositoryInterface $repository,
        private SignUpRepositoryInterface $signUpRepository,
        private UserInfoRepository $infoRepository
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

    public function delete(Uuid4 $id)
    {
        $this->signUpRepository->delete($id);

        return true;
    }

    public function getId(Email $email)
    {
        return $this->infoRepository->getIdByEmail($email);
    }
}