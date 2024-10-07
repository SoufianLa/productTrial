<?php

namespace App\Component;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class Responder implements IResponder
{
    public function __construct(readonly private SerializerInterface $serializer)
    {
    }

    public function render($data, $statusCode = Response::HTTP_OK, $groups = [],
        $headers =  ['Content-Type' => 'application/json'], $type='json'): Response
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups($groups)
            ->toArray();

        return new Response(
            $this->serializer->serialize($data, $type, $context),
            $statusCode,
            $headers
        );
    }
}