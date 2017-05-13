<?php
/**
 * This file is a part of MyShowdown - BackendApp project.
 *
 * @author Alexandr Viniychuk <a@viniychuk.com>
 * created: 2/24/17 9:00 PM
 */

namespace Youshido\SocialNetworksBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Youshido\SocialNetworksBundle\Model\Document\AbstractSocialAccount;
use Youshido\SocialNetworksBundle\Model\SocialableUserInterface;

class SocialNetworkHelper
{
    /**
     * @var
     */
    private $providerFactory;

    private $om;
    private $userModel;
    private $socialAccountModel;

    public function __construct(ProviderFactory $providerFactory, ObjectManager $om, array $models)
    {
        $this->providerFactory    = $providerFactory;
        $this->om                 = $om;
        $this->userModel          = $models['user'];
        $this->socialAccountModel = $models['social_account'];
    }

    public function generateSocialAuthUrls($providers = [])
    {
        $urls = [];

        if (empty($providers)) $providers = $this->providerFactory->getActiveProviders();

        foreach ($providers as $provider) {
            $urls[] = [
                'type' => $provider->getType(),
                'url'  => $provider->getAuthUrl()
            ];
        }

        return $urls;
    }

    /**
     * @param $providerType
     * @param $code
     * @return SocialAccountInfo
     */
    public function processCode($providerType, $code)
    {
        return $this->providerFactory->getProvider($providerType)->getUserInfoWithAuthCode($code);
    }

    public function processAccessToken($providerType, $accessToken)
    {
        return $this->providerFactory->getProvider($providerType)->getUserInfoWithAccessToken($accessToken);

    }

    public function persistSocialAccountFromCode($providerType, $code)
    {
        $info = $this->processCode($providerType, $code);

        /** @var AbstractSocialAccount $socialAccount */
        return $this->persistSocialAccount($providerType, $info);
    }

    /**
     * @param $providerType
     * @param $accessToken
     * @return AbstractSocialAccount
     */
    public function persistSocialAccountFromAccessToken($providerType, $accessToken)
    {
        $info = $this->processAccessToken($providerType, $accessToken);

        return $this->persistSocialAccount($providerType, $info);
    }

    public function ensureUserForSocialAccount(AbstractSocialAccount $socialAccount)
    {
        if (!$socialAccount->getUser()) {

            $user = $socialAccount->getEmail() ? $this->om->getRepository($this->userModel)->findOneBy(['email' => $socialAccount->getEmail()]) : null;
            if (!$user) {
                /** @var SocialableUserInterface $user */
                $user = new $this->userModel();
                $user->setFirstName($socialAccount->getFirstName());
                $user->setLastName($socialAccount->getLastName());
                $user->setEmail($socialAccount->getEmail());
                $this->om->persist($user);
            }
            $socialAccount->setUser($user);
            $this->om->flush();
        }
        return $socialAccount->getUser();
    }

    public function getUserFromRequest($providerType, $code)
    {
        $socialAccount = $this->persistSocialAccountFromCode($providerType, $code);
        return $this->ensureUserForSocialAccount($socialAccount);
    }

    /**
     * @param $providerType
     * @param $info
     * @return AbstractSocialAccount|null
     */
    public function persistSocialAccount($providerType, $info)
    {
        $socialAccount = $this->om->getRepository($this->socialAccountModel)->findOneBy([
            'socialId' => (string)$info->getId(),
            'provider' => $providerType
        ]);

        if (!$socialAccount) {
            /** @var AbstractSocialAccount $socialAccount */
            $socialAccount = new $this->socialAccountModel;
            $socialAccount->setSocialId($info->getId());
            $socialAccount->setProvider($providerType);
            $socialAccount->setFirstName($info->getFirstName());
            $socialAccount->setLastName($info->getLastName());
            $socialAccount->setEmail($info->getEmail());
        }
        $socialAccount->setRawSocialInfo($info);
        $socialAccount->setImageUrl($info->getImageUrl());

        $this->om->persist($socialAccount);
        $this->om->flush();

        return $socialAccount;
    }
}