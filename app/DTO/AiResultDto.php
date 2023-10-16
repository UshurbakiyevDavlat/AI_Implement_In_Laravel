<?php

namespace App\DTO;

class AiResultDto
{
    public function __construct(
        public readonly string $output,
        public readonly int $tokens,
    ) {}
}
