<?php

namespace App\ErrorHandler;

use App\Component\IResponder;
use App\DTO\Contract\ErrorResponseDTO;
use App\Exception\ApiException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class ApiExceptionHandler implements EventSubscriberInterface
{
    public function __construct(readonly private IResponder $responder){

    }
    public function onKernelException(ExceptionEvent $event)
    {
        $e = $event->getThrowable();
        if (!$e instanceof ApiException) {
            return;
        }
        $statusCode = $e->getStatusCode();
        $problemDetails = new ErrorResponseDTO('API Exception', $e->getMessage());
        $headers = array_merge(['Content-Type'=> 'application/problem+json'], $e->getHeaders());
        $response = $this->responder->render($problemDetails, $statusCode, [], $headers);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

}