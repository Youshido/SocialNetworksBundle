<?php

namespace Youshido\SocialNetworksBundle\Service\Provider;

use Facebook\Facebook;
use Youshido\SocialNetworksBundle\Service\SocialAccountInfo;

class FacebookProvider extends AbstractSocialProvider
{

    /** @var Facebook */
    private $client = null;

    public function initialize($config)
    {
        $this->client = new Facebook([
            'app_id'     => $config['app_id'],
            'app_secret' => $config['app_secret'],
        ]);

        $this->client->getPageTabHelper()->getSignedRequest();
    }

    /**
     * @return string
     */
    public function getAuthUrl() : string
    {
        $helper = $this->client->getRedirectLoginHelper();

        return $helper->getLoginUrl($this->generateAuthRedirectUrl(), ['email']);
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'facebook';
    }

    /**
     * @param $authCode
     *
     * @return SocialAccountInfo
     */
    public function getUserInfo($authCode)
    {
        $oAuth2Client = $this->client->getOAuth2Client();
        $accessToken  = $oAuth2Client->getAccessTokenFromCode($authCode, $this->generateAuthRedirectUrl());

        $response = $this->client->get('/me?fields=first_name,last_name,email,picture.type(large),gender,age_range', $accessToken);
        $profile  = $response->getGraphUser();

        $socialInfo = new SocialAccountInfo(
            $profile->getId(),
            $profile->getFirstName(),
            $profile->getLastName(),
            $profile->getEmail(),
            $profile->getPicture()->getUrl(),
            $accessToken->getValue()
        );
        $socialInfo->setGender($profile->getGender());
        $socialInfo->setAdditionalInfo($profile);

        return $socialInfo;
    }
}