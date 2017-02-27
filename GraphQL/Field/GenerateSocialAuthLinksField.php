<?php

namespace Youshido\SocialNetworksBundle\GraphQL\Field;

use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Object\ObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\SocialNetworksBundle\GraphQL\Type\SocialProviderType;

/**
 * This file is a part of MyShowdown - BackendApp project.
 *
 * @author Alexandr Viniychuk <a@viniychuk.com>
 * created: 2/25/17 12:25 AM
 */
class GenerateSocialAuthLinksField extends AbstractField
{

    public function resolve($value, array $args, ResolveInfo $info)
    {
        return $info->getContainer()->get('social_network_helper')->generateSocialAuthUrls();
    }


    public function getType()
    {
        return new ListType(new ObjectType([
            'name'   => 'SocialAuthLink',
            'fields' => [
                'url'  => new StringType(),
                'type' => new SocialProviderType()
            ]
        ]));
    }

}