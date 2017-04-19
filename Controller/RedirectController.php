<?php

namespace Youshido\SocialNetworksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends Controller
{

    public function processRedirectAction(Request $request)
    {
        $type = $request->get('type');
        $code = $request->query->has('code') ? $request->get('code') : ($request->query->has('oauth_verifier') ? $request->query->get('oauth_verifier') : null);

        $data = json_encode(['type' => $type, 'code' => $code]);
        return new Response(<<<DATA
        <script>
        window.opener && window.opener.postMessage(JSON.stringify({$data}), '*');
        window.close();
        </script>
DATA
);
    }
}
