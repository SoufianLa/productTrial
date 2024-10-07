<?php

namespace App\Component;

use Symfony\Component\HttpFoundation\Response;

interface IResponder
{
    public function render($data, int $statusCode= Response::HTTP_OK, array $groups=[], array $headers= []): Response;
}