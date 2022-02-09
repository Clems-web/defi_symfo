<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class KernelRequestListener
{
    public function onKernelRequest(RequestEvent $requestEvent) {
        $event = $requestEvent->getRequest()->getRealMethod();

        if ($event !== 'POST') {
            //$requestEvent->setResponse(new Response('<h1>Type de requête non autorisée par le kernel</h1>'));
            $requestEvent->setResponse(new Response(null, 403));
        }
    }
}