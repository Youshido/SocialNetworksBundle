<?php

namespace Youshido\SocialNetworksBundle\Service\Provider;


use Abraham\TwitterOAuth\TwitterOAuth;
use Doctrine\Common\Cache\FilesystemCache;
use Youshido\SocialNetworksBundle\Service\SocialAccountInfo;

class TwitterProvider extends AbstractSocialProvider
{

    const SESSION_KEY_AUTH_DATA = 'app.session.twitter';

    /** @var TwitterOAuth */
    private $client;

    /** @var  FilesystemCache */
    private $cache;

    public function __construct(FilesystemCache $cache)
    {
        $this->cache  = $cache;
    }

    public function initialize($config)
    {
        $this->client = new TwitterOAuth($config['api_key'], $config['api_secret']);
    }

    /**
     * @return string
     */
    public function getAuthUrl()
    {
        $tokenInfo = $this->client->oauth("oauth/request_token", [
            'oauth_callback'     => $this->generateAuthRedirectUrl(),
            'x_auth_access_type' => 'read'
        ]);

        $this->cache->save(self::SESSION_KEY_AUTH_DATA, $tokenInfo);

        return $this->client->url("oauth/authorize", ["oauth_token" => $tokenInfo['oauth_token']]);
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'twitter';
    }

    public function getUserInfo($authCode)
    {
        $tokenInfo = $this->cache->fetch(self::SESSION_KEY_AUTH_DATA);
        $this->client->setOauthToken($tokenInfo['oauth_token'], $tokenInfo['oauth_token_secret']);

        $accessToken = $this->client->oauth("oauth/access_token", ["oauth_verifier" => $authCode]);
        $this->client->setOauthToken($accessToken['oauth_token'], $accessToken['oauth_token_secret']);

        $user = $this->client->get("account/verify_credentials", ['include_email' => true, 'skip_status' => true, 'include_entities' => false]);

        return new SocialAccountInfo($user->name, null, empty($user->email) ? null : $user->email, isset($user->profile_image_url) ? $user->profile_image_url : null, [
            'id'          => $user->id,
            'accessToken' => $accessToken
        ]);
    }
}