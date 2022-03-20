<?php

namespace KeycloakBundle\DependencyInjection;

use KeycloakBundle\Keycloak\Logger\DefaultLogger;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function __construct(private bool $debug)
    {
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('keycloak');
        $root = $treeBuilder->getRootNode();

        $this->configureRealmSettings($root);
        $this->configureKeycloakClient($root);

        return $treeBuilder;
    }

    private function configureKeycloakClient(ArrayNodeDefinition|NodeDefinition $root): void
    {
        $root
            ->children()
                ->arrayNode('http_client')
                    ->children()
                        ->scalarNode('base_uri')->isRequired()->end()
                        ->scalarNode('logger')
                            ->defaultValue($this->debug ? DefaultLogger::ID : false)
                            ->treatNullLike(DefaultLogger::ID)
                            ->treatTrueLike(DefaultLogger::ID)
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function configureRealmSettings(ArrayNodeDefinition|NodeDefinition $root): void
    {
        $root
            ->children()
                ->arrayNode('realms')
                    ->arrayPrototype()
                    ->treatNullLike([])
                        ->children()
                            ->scalarNode('realmName')->isRequired()->end()
                            ->arrayNode('connections')
                                ->treatNullLike([])
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('clientId')->isRequired()->end()
                                        ->scalarNode('clientSecret')->isRequired()->end()
                                        ->booleanNode('admin')->defaultFalse()->end()
                                    ->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end()
        ;
    }
}