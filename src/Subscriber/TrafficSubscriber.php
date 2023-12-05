<?php

namespace App\Subscriber;

use App\Service\TrafficService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TrafficSubscriber implements EventSubscriberInterface
{
    private TrafficService $traffic;

    public function __construct(TrafficService $traffic)
    {
        $this->traffic = $traffic;
    }

    public static function getSubscribedEvents()
    {
        return [
          'kernel.request' => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $headers = $request->headers;

        if ($headers) {
            $this->traffic->record($headers);
        }
    }
}