<?php

namespace Youshido\SocialNetworksBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('social_networks');

        $rootNode
            ->children()
                ->scalarNode('web_host')
                ->end()
                ->arrayNode('models')
                    ->children()
                        ->scalarNode('user')->cannotBeEmpty()->defaultValue('App:User')->end()
                        ->scalarNode('social_account')->cannotBeEmpty()->defaultValue('App:SocialAccount')->end()
                    ->end()
                ->end()
                ->enumNode('platform')
                    ->values(['orm', 'odm'])
                    ->defaultValue('orm')
                ->end()
                ->arrayNode('networks')
                    ->children()
                        ->arrayNode('facebook')
                            ->children()
                                ->scalarNode('app_id')->cannotBeEmpty()->end()
                                ->scalarNode('app_secret')->cannotBeEmpty()->end()
                                ->scalarNode('fields')->end()
                            ->end()
                        ->end()
                        ->arrayNode('twitter')
                            ->children()
                                ->scalarNode('api_key')->cannotBeEmpty()->end()
                                ->scalarNode('api_secret')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
//                    ->useAttributeAsKey('network')
//                        ->prototype('array')
//                            ->children()
//                                ->booleanNode('active')->defaultValue(true)->end()
//                                ->scalarNode('client_id')->cannotBeEmpty()->end()
//                                ->scalarNode('client_secret')->cannotBeEmpty()->end()
//                            ->end()
//                        ->end()
//                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
