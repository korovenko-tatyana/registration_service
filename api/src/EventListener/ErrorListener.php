<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorListener
{
    public function onJWTExpired(JWTExpiredEvent $event): void
    {
        $this->errorMessage($event, 401);
    }

    public function onJWTInvalid(JWTInvalidEvent $event): void
    {
        $this->errorMessage($event, 401);
    }

    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $this->errorMessage($event, 401);
    }

    public function errorMessage(object &$event, int $statusCode): void
    {
        $response = new JsonResponse(['errorMessage' => 'unauthorized'], $statusCode);

        $event->setResponse($response);
    }
}
