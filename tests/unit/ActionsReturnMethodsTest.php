<?php

namespace KeycloakBundle\Tests\unit;

use KeycloakBundle\Keycloak\Configuration\Realization\Configuration;
use KeycloakBundle\Keycloak\DTO\Common\Collections\Realization\Credentials;
use KeycloakBundle\Keycloak\DTO\Common\Credential\Realization\Password;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Name;
use KeycloakBundle\Keycloak\DTO\Common\Username;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\ClientCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\LoginAction;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\UserManagement\SignUpAction;
use PHPUnit\Framework\TestCase;

class ActionsReturnMethodsTest extends TestCase
{
    public function testLoginActionMethod()
    {
        $action = new LoginAction(new ClientCredentials('', ''), new Configuration('', '', ''));

        self::assertEquals(Method::POST, $action->getMethod());
        self::assertInstanceOf(Action::class, $action);
    }

    public function testSignUpActionMethod()
    {
        $action = new SignUpAction(
            new UserRepresentation(
                Uuid4::new(),
                new Username(''),
                new Email('aaa@aaa.com'),
                new Credentials([new Password('', false)]),
                true,
                new Name('', '')
            ),
            new AccessToken('', 1),
            new Configuration('', '', '')
        );

        self::assertEquals(Method::POST, $action->getMethod());
        self::assertInstanceOf(Action::class, $action);
    }
}