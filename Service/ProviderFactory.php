<?php

namespace Youshido\SocialNetworksBundle\Service;


use Youshido\SocialNetworksBundle\Service\Provider\AbstractSocialProvider;

class ProviderFactory
{
    const TYPE_FACEBOOK    = 'facebook';
    const TYPE_TWITTER     = 'twitter';
    const TYPE_LINKEDIN    = 'linkedin';
    const TYPE_GOOGLE_PLUS = 'google';

    /** @var AbstractSocialProvider[] */
    private $providers;

    /**
     * @return AbstractSocialProvider[]
     */
    public function getActiveProviders()
    {
        return $this->providers;
    }

    public function getProvider(string $type) : AbstractSocialProvider
    {
        if (array_key_exists($type, $this->providers)) {
            return $this->providers[$type];
        }

        throw new \InvalidArgumentException(sprintf('Not supported provider type "%s"', $type));
    }

    public function addProvider(AbstractSocialProvider $provider)
    {
        $this->providers[$provider->getType()] = $provider;
    }

    public function getTypes() : array
    {
        return array_keys($this->providers);
    }

}