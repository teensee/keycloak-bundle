<?php

namespace KeycloakBundle\Tests\unit;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Client\Realization\KeycloakClient;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\Configuration\Realization\Configuration;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;
use KeycloakBundle\Keycloak\Http\Repository\Realization\User\Authorization\AuthorizationRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class InstanceOfTest extends TestCase
{
    public function testKeycloakHttpClient()
    {
        $client = new KeycloakClient(HttpClient::createForBaseUri('http://google.com'));
        self::assertInstanceOf(ClientInterface::class, $client);
    }

    public function testLoginRepository()
    {
        $httpClient = new KeycloakClient(HttpClient::createForBaseUri('http://google.com'));
        $configuration = new Configuration('test','test','test');

        self::assertInstanceOf(ConfigurationInterface::class, $configuration);

        $loginRepository = new AuthorizationRepository($httpClient, $configuration);
        self::assertInstanceOf(AuthorizationRepositoryInterface::class, $loginRepository);
    }
}