<?php

namespace KeycloakBundle\Tests\functional\Client;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;
use KeycloakBundle\Tests\KeycloakTestingKernel;
use KeycloakBundle\Tests\Services\Http\StubAction;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Kernel;

class ClientFunctionalTest extends TestCase
{
    private Kernel $kernel;

    protected function setUp(): void
    {
        $this->kernel = new KeycloakTestingKernel([
            'http_client' => [
                'base_uri' => 'http://google.com'
            ],
            'realms' => [
                'test_realm' => [
                    'realmName' => 'stubRealm',
                    'connections' => [
                        'firstStub' => [
                            'clientId' => 'firstStub',
                            'clientSecret' => 'test',
                            'admin' => false
                        ],
                        'secondStub' => [
                            'clientId' => 'secondStub',
                            'clientSecret' => 'test2',
                            'admin' => true
                        ]
                    ]
                ]
            ]
        ]);

        $this->kernel->boot();

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testHttpClientServiceWiring()
    {
        $container = $this->kernel->getContainer();
        $httpClient =  $container->get('keycloak.stub_http_client');

        self::assertInstanceOf(ClientInterface::class, $httpClient);

        $action = new StubAction();

        self::assertInstanceOf(ActionInterface::class, $action);
        self::assertEquals(Method::GET, $action->getMethod());

        $result = $httpClient->execute($action);
        self::assertJson($result);
        self::assertJsonStringEqualsJsonString($result, '{"result": "ok"}');
    }
}