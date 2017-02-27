<?php

namespace Youshido\SocialNetworksBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Youshido\SocialNetworksBundle\DependencyInjection\CompilerPass\SocialNetworksCompilerPass;

class SocialNetworksBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SocialNetworksCompilerPass());
    }


}
