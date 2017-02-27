<?php

namespace Youshido\SocialNetworksBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Youshido\SocialNetworksBundle\Service\ProviderFactory;

class SocialNetworksCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $factoryDefinition = new Definition();
        $factoryDefinition->setClass(ProviderFactory::class);
        $networks = $container->getParameter('social_networks.networks');
        foreach ($networks as $type => $config) {
            $providerServiceId = 'social_provider.' . $type;

            $container->getDefinition($providerServiceId)->addMethodCall('initialize', [$config]);
            $factoryDefinition->addMethodCall('addProvider', [new Reference($providerServiceId)]);
        }

        $platform     = $container->getParameter('social_networks.platform');
        switch ($platform) {
            case 'orm':
                $container->setAlias('social_networks.om', 'doctrine.orm.entity_manager');
                break;

            case 'odm':
                $container->setAlias('social_networks.om', 'doctrine_mongodb.odm.document_manager');
                break;
        }

        $container->setDefinition('social_networks.factory', $factoryDefinition);
    }
}
