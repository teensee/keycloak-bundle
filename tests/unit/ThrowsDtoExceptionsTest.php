<?php

namespace KeycloakBundle\Tests\unit;

use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\Exception\DTO\User\ModelException;
use PHPUnit\Framework\TestCase;

class ThrowsDtoExceptionsTest extends TestCase
{
    public function testCorrectEmailInjection()
    {
        $correctEmail = new Email('example@email.com');
        self::assertInstanceOf(Email::class, $correctEmail);
    }

    public function testIncorrectEmail()
    {
        $this->expectException(ModelException::class);
        $this->expectExceptionCode(400);

        $incorrectEmail = new Email('example.email.com');
    }

    public function testCorrectUuidPassed()
    {
        $uuid = Uuid4::fromString('74cf7feb-e155-485a-93e7-14e4d47179cb');
        self::assertInstanceOf(Uuid4::class, $uuid);
    }

    public function testIncorrectUuidPassed()
    {
        $this->expectException(ModelException::class);
        $this->expectExceptionCode(400);

        $incorrectUuid = Uuid4::fromString('incorrect-uuid');
    }
}