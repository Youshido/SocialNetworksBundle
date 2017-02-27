<?php

namespace Youshido\SocialNetworksBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SocialNetworksExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('social_networks.web_host', empty($config['web_host']) ? "" : $config['web_host']);
        $container->setParameter('social_networks.networks', $config['networks']);
        $container->setParameter('social_networks.models', $config['models']);
        $container->setParameter('social_networks.platform', $config['platform']);

        foreach ($config['networks'] as $network => $networkConfig) {
            $container->setParameter('social_networks.networks.' . $network, $networkConfig);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
