<?php

namespace KeycloakBundle\Tests\api;

use Faker\Factory;
use Faker\Generator;
use KeycloakBundle\Keycloak\DTO\Common\Collections\Realization\Credentials;
use KeycloakBundle\Keycloak\DTO\Common\Credential\Realization\Password;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Name;
use KeycloakBundle\Keycloak\DTO\Common\Username;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\UseCase\Authorization\Realization\AuthorizationManager;
use KeycloakBundle\Tests\KeycloakTestingKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class AuthorizationTest extends WebTestCase
{
    private UserRepresentation $currentUser;
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        self::$kernel = new KeycloakTestingKernel([
            'http_client' => [
                'base_uri' => $_ENV['KEYCLOAK_AUTH_URL']
            ],
            'realms' => [
                'test_realm' => [
                    'realmName' => $_ENV['KEYCLOAK_REALM'],
                    'connections' => [
                        'firstStub' => [
                            'clientId' => $_ENV['KEYCLOAK_CLIENT_ID'],
                            'clientSecret' => $_ENV['KEYCLOAK_CLIENT_SECRET'],
                            'admin' => false
                        ],
                        'secondStub' => [
                            'clientId' => $_ENV['KEYCLOAK_ADMIN_CLIENT_ID'],
                            'clientSecret' => $_ENV['KEYCLOAK_ADMIN_CLIENT_SECRET'],
                            'admin' => true
                        ]
                    ]
                ]
            ]
        ]);

        self::$kernel->boot();
        $this->faker = Factory::create();
    }

    /**
     * @beforeClass
     */
    public function setupCurrentUserDTO()
    {
        $this->currentUser = new UserRepresentation(
            Uuid4::fromString($this->faker->uuid),
            new Username($this->faker->userName),
            new Email($this->faker->email),
            new Credentials([new Password($this->faker->password, false)]),
            true,
            new Name($this->faker->firstName, $this->faker->lastName)
        );
    }

    public function testSignUp()
    {
        $container = self::$kernel->getContainer();
        $authorizationManager = $container->get(AuthorizationManager::class);
        self::assertInstanceOf(AuthorizationManager::class, $authorizationManager);

        $result = $authorizationManager->signUp($this->currentUser);
        self::assertTrue($result);
    }

    public function testGetUserId()
    {
        $container = self::$kernel->getContainer();
        $authorizationManager = $container->get(AuthorizationManager::class);
        self::assertInstanceOf(AuthorizationManager::class, $authorizationManager);

        $id = $authorizationManager->getId($this->currentUser->getEmail());

        self::assertNotNull($id);
    }

    public function testGetIdAndDelete()
    {
        $container = self::$kernel->getContainer();
        $authorizationManager = $container->get(AuthorizationManager::class);
        self::assertInstanceOf(AuthorizationManager::class, $authorizationManager);

        $raw = $authorizationManager->getId($this->currentUser->getEmail());

        $decoded = json_decode($raw, true);
        $authorizationManager->delete(Uuid4::fromString($decoded[0]['id']));
    }

}