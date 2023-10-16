<?php

namespace App\DTO;

use App\Enums\AiContextRole;

class AiCommandDto
{
    /**
     *  @param string $prompt
     *  @param string $identity
     *  @param AiContextRole[] $context
     */
    public function __construct(
        public readonly string $prompt,
        public readonly string $identity,
        public readonly array $context = [],
    ) {}
}
