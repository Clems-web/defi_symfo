<?php

namespace App\EventSubscriber;

use App\Kernel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class KernelEventSubscriber implements EventSubscriberInterface {

    private KernelInterface $appkernel;

    public function __construct(KernelInterface $kernel) {
        $this->appkernel = $kernel;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['logKernelExceptionTriggered', 255]
            ],

            KernelEvents::REQUEST => [
                ['onKernelRequest', 0]
            ]
        ];
    }

    public function onKernelRequest(RequestEvent $requestEvent) {
        $event = $requestEvent->getRequest()->getRealMethod();

        if ($event !== 'POST') {
            //$requestEvent->setResponse(new Response('<h1>Type de requête non autorisée par le kernel</h1>'));
            $requestEvent->setResponse(new Response(null, 403));
        }
    }

    public function logKernelExceptionTriggered(ExceptionEvent $exceptionEvent) {
        $logDir = $this->appkernel->getLogDir();
        $response = $exceptionEvent->getThrowable()->getMessage();
        file_put_contents($logDir.'/example.log', "$response\n", FILE_APPEND);
    }
}