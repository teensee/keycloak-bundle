<?php

namespace KeycloakBundle\DependencyInjection;

use Exception;
use KeycloakBundle\Keycloak\Client\Realization\KeycloakClient;
use KeycloakBundle\Keycloak\Configuration\Realization\Configuration as KeycloakConfiguration;
use KeycloakBundle\Keycloak\Http\Repository\Realization\User\Authorization\AuthorizationRepository;
use KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserInfo\UserInfoRepository;
use KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserManagement\SignUpRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KeycloakExtension extends Extension
{
    private array $configurations;

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container->getParameter('kernel.debug'));
        $config        = $this->processConfiguration($configuration, $configs);

        if (!isset($config['http_client'])) {
            throw new Exception('http_client must be defined with option base_uri');
        }

        $this->registerHttpClient($config['http_client'], $container);
        $this->instantiateKeycloakHttpClients($config['realms'], $container);
        $this->instantiateManagers($container);

        $loader = new Loader\ProtectedPhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');
    }

    /**
     * @param array            $httpClient
     * @param ContainerBuilder $container
     */
    protected function registerHttpClient(array $httpClient, ContainerBuilder $container): void
    {
        $container->register('http_client.keycloak_client', HttpClient::class)
                  ->setFactory([HttpClient::class, 'createForBaseUri'])
                  ->setArguments([$httpClient['base_uri'], [], 6, 50]);

        $clientDefinition = new Definition(KeycloakClient::class, [
            $container->getDefinition('http_client.keycloak_client'),
        ]);

        $logger = $httpClient['logger'];
        if (false !== $logger) {
            $clientDefinition->addMethodCall('setLogger', [new Reference($logger)]);
        }

        $container->setDefinition("keycloak.http_client", $clientDefinition);
    }

    private function instantiateKeycloakHttpClients(array $realmCfg, ContainerBuilder $container)
    {
        foreach ($realmCfg as $realmName => $connections) {
            foreach ($connections['connections'] as $clientName => $connection) {
                $registeredClientName = "keycloak.keycloak_api_client.{$clientName}";

                $clientDefinition = new Definition(KeycloakConfiguration::class);
                $clientDefinition->setArguments([
                    $connection['clientId'],
                    $connection['clientSecret'],
                    $connections['realmName']
                ]);

                $container->setDefinition($registeredClientName, $clientDefinition);

                $this->configurations[$clientName] = [
                    'id' => $registeredClientName,
                    'reference' => new Reference($registeredClientName),
                    'admin' => $connection['admin']
                ];
            }
        }

        $this->loadRepositories($container);
    }

    private function loadRepositories(ContainerBuilder $container): void
    {
        foreach ($this->configurations as $configuration) {
            $loginRepositoryDef = new Definition(AuthorizationRepository::class, [
                new Reference('keycloak.http_client'),
                $configuration['reference'],
            ]);

            $adminPrefix = $configuration['admin'] === true ? '_admin' : '';

            $container->setDefinition("keycloak.http.repository.login{$adminPrefix}", $loginRepositoryDef);

            if ($container->has('keycloak.http.repository.login_admin') && true === $configuration['admin']) {
                $signUpRepositoryDef = new Definition(SignUpRepository::class, [
                    $container->getDefinition('keycloak.http.repository.login_admin'),
                    $container->getDefinition('keycloak.http_client'),
                    $configuration['reference']
                ]);

                $container->setDefinition("keycloak.http.repository.signup", $signUpRepositoryDef);

                $infoRepositoryDef = new Definition(UserInfoRepository::class, [
                    $container->getDefinition('keycloak.http.repository.login_admin'),
                    $container->getDefinition('keycloak.http_client'),
                    $configuration['reference']
                ]);

                $container->setDefinition('keycloak.http.repository.user_info', $infoRepositoryDef);
            }
        }
    }

    private function instantiateManagers(ContainerBuilder $container)
    {

    }
}