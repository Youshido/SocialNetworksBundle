<?php

namespace Youshido\SocialNetworksBundle\GraphQL\Type;


use Youshido\GraphQL\Type\Enum\AbstractEnumType;
use Youshido\SocialNetworksBundle\Service\ProviderFactory;

class SocialProviderType extends AbstractEnumType
{

    /**
     * @return array
     */
    public function getValues()
    {
        return [
            [
                'name'  => ProviderFactory::TYPE_GOOGLE_PLUS,
                'value' => ProviderFactory::TYPE_GOOGLE_PLUS
            ],
            [
                'name'  => ProviderFactory::TYPE_FACEBOOK,
                'value' => ProviderFactory::TYPE_FACEBOOK
            ],
            [
                'name'  => ProviderFactory::TYPE_TWITTER,
                'value' => ProviderFactory::TYPE_TWITTER
            ],
            [
                'name'  => ProviderFactory::TYPE_LINKEDIN,
                'value' => ProviderFactory::TYPE_LINKEDIN
            ],
        ];
    }
}