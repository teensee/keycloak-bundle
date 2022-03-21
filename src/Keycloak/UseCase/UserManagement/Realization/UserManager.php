<?php

namespace KeycloakBundle\Keycloak\UseCase\UserManagement\Realization;

use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\DTO\User\Response\UserManagement\UserInfo;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Registration\SignUpRepositoryInterface;
use KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserInfo\UserInfoRepository;

class UserManager
{
    public function __construct(
        private SignUpRepositoryInterface $signUpRepository,
        private UserInfoRepository $infoRepository
    ) {

    }

    public function addUser(UserRepresentation $user)
    {
        $this->signUpRepository->signup($user);
    }

    public function deleteUser(Uuid4 $id)
    {
        $this->signUpRepository->delete($id);

        return true;
    }

    public function getId(Email $email): Uuid4
    {
        return $this->infoRepository->getIdByEmail($email);
    }

    public function getUserInfo(Email $email): UserInfo
    {
        return $this->infoRepository->getUserInfo($email);
    }
}