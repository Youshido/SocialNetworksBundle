<?php

namespace Youshido\SocialNetworksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends Controller
{

    public function processRedirectAction(Request $request)
    {
        $type = $request->get('type');
        $code = $request->query->has('code') ? $request->get('code') : ($request->query->has('oauth_verifier') ? $request->query->get('oauth_verifier') : null);

        /** @var Container $container */
        $container = $this->container;
        $data = $container->get('social_network_helper')->getUserFromRequest($type, $code);

        return new JsonResponse([
            'type' => $type,
            'code' => $code
        ]);
    }
}
