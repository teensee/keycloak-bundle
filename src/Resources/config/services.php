<?php

namespace KeycloakBundle;

use KeycloakBundle\Keycloak\Logger\DefaultLogger;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
                          ->defaults()
                          ->autowire()
                          ->autoconfigure();

    $services->load('KeycloakBundle\\', __DIR__.'/../../*')
             ->exclude([
                 '../../{DependencyInjection,Tests,Resources}',
                 '../../Keycloak/{Http,Enum,DTO,Exception,Configuration,Client,Logger}',
             ])
    ;

    $services->set(DefaultLogger::ID)
             ->class(DefaultLogger::class)
             ->args(['$logger' => service('monolog.logger'), '$debug' => param('kernel.debug')])
             ->tag('monolog.logger', ['channel' => 'keycloak']);
};
