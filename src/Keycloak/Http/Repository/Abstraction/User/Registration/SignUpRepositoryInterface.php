<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Registration;

use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;

interface SignUpRepositoryInterface
{
    public function signup(UserRepresentation $user);

    public function delete(Uuid4 $id): string;
}