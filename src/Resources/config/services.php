<?php

namespace KeycloakBundle;

use KeycloakBundle\Keycloak\Logger\DefaultLogger;
use KeycloakBundle\Keycloak\UseCase\Authorization\Realization\AuthorizationManager;
use KeycloakBundle\Keycloak\UseCase\UserManagement\Realization\UserManager;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
                          ->defaults()
                          ->autowire()
                          ->autoconfigure();

    if (defined('PHPUNIT_COMPOSER_INSTALL') || defined('__PHPUNIT_PHAR__')) {
        $services->public();
    }

    $services->load('KeycloakBundle\\', __DIR__.'/../../*')
             ->exclude([
                 '../../{DependencyInjection,Tests,Resources}',
                 '../../Keycloak/{Http,Enum,DTO,Exception,Configuration,Client,Logger}',
             ]);

    $services->set(DefaultLogger::ID)
             ->class(DefaultLogger::class)
             ->args([
                 service('logger')->nullOnInvalid(),
                 param('kernel.debug')
             ])
             ->tag('monolog.logger', ['channel' => 'keycloak']);

    $services->set(AuthorizationManager::class)
             ->args([
                 service('keycloak.http.repository.login'),
                 service('keycloak.http.repository.signup'),
                 service('keycloak.http.repository.user_info')
             ]);


    $services->set(UserManager::class)
             ->args([
                 service('keycloak.http.repository.signup'),
                 service('keycloak.http.repository.user_info')
             ]);
};
