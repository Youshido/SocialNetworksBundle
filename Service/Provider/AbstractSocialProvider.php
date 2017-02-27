<?php
namespace Youshido\SocialNetworksBundle\Service\Provider;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Youshido\SocialNetworksBundle\Service\SocialAccountInfo;

abstract class AbstractSocialProvider
{

    /** @var  RouterInterface */
    private $router;

    protected $webHost;

    /**
     * @return string
     */
    abstract function getType();

    /**
     * @param $authCode
     *
     * @return SocialAccountInfo
     */
    abstract public function getUserInfo($authCode);

    /**
     * @return string
     */
    abstract public function getAuthUrl();

    /**
     * @return string
     */
    public function generateAuthRedirectUrl()
    {
        $currentHost = $this->router->getContext()->getHost();

        $this->router->getContext()->setHost($this->webHost);
        $url = $this->router->generate('app.social.auth_redirect', ['type' => $this->getType()], UrlGeneratorInterface::ABSOLUTE_URL);
        $this->router->getContext()->setHost($currentHost);

        return $url;
    }

    public function setParameters($webHost)
    {
        $this->webHost = $webHost;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }
}