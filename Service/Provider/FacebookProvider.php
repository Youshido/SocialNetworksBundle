<?php

namespace Youshido\SocialNetworksBundle\Service\Provider;

use Facebook\Facebook;
use Youshido\SocialNetworksBundle\Service\SocialAccountInfo;

/**
 * Class FacebookProvider
 *
 * @package Youshido\SocialNetworksBundle\Service\Provider
 */
class FacebookProvider extends AbstractSocialProvider
{
    /** @var Facebook */
    private $client = null;

    private $config;

    /**
     * @param array $config
     */
    public function initialize($config)
    {
        $this->config = $config;
        $this->client = new Facebook([
            'app_id'     => $config['app_id'],
            'app_secret' => $config['app_secret'],
        ]);

        $this->client->getPageTabHelper()->getSignedRequest();
    }

    /**
     * @return string
     */
    public function getAuthUrl(): string
    {
        $helper = $this->client->getRedirectLoginHelper();

        return $helper->getLoginUrl($this->generateAuthRedirectUrl(), ['email']);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'facebook';
    }

    /**
     * @param string $authCode
     *
     * @return SocialAccountInfo
     */
    public function getUserInfoWithAuthCode($authCode)
    {
        $oAuth2Client = $this->client->getOAuth2Client();
        $accessToken  = $oAuth2Client->getAccessTokenFromCode($authCode, $this->generateAuthRedirectUrl());

        return $this->getUserInfoWithAccessToken($accessToken->getValue());
    }

    /**
     * @param string $accessToken
     *
     * @return SocialAccountInfo
     */
    public function getUserInfoWithAccessToken($accessToken)
    {
        $permissions = empty($this->config['fields']) ? '' : (',' . $this->config['fields']);
        $response    = $this->client->get('/me?fields=first_name,last_name,email,picture.type(large),gender,age_range' . $permissions, $accessToken);
        $profile     = $response->getGraphUser();

        $socialInfo = new SocialAccountInfo(
            $profile->getId(),
            $profile->getFirstName(),
            $profile->getLastName(),
            $profile->getEmail(),
            $profile->getPicture()->getUrl(),
            $accessToken
        );
        $socialInfo->setGender($profile->getGender());
        $socialInfo->setAdditionalInfo($profile);

        return $socialInfo;
    }
}
