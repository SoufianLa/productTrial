<?php

namespace App\DTO\Contract;

class ErrorResponseDTO
{

    public function __construct(readonly public ?string $title, readonly public ?string $description)
    {

    }

}