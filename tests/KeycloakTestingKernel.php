<?php

namespace KeycloakBundle\Tests;

use KeycloakBundle\KeycloakBundle;
use KeycloakBundle\Tests\Services\Stubs\StubHttpClient;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class KeycloakTestingKernel extends Kernel
{
    private array $keycloakConfig;

    public function __construct(array $keycloakConfig)
    {
        $this->keycloakConfig = $keycloakConfig;

        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new KeycloakBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $builder) {
            $builder->loadFromExtension('keycloak', $this->keycloakConfig);

            $builder
                ->register('keycloak.stub_http_client', StubHttpClient::class)
                ->setPublic(true);
        });
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/cache/'.spl_object_hash($this);
    }
}