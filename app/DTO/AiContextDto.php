<?php

namespace App\DTO;

use App\Enums\AiContextRole;

class AiContextDto
{
    public function __construct(
        public readonly string $content,
        public readonly AiContextRole $role
    ) {}
}
