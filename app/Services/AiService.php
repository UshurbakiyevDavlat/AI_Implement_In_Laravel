<?php

namespace App\Services;

use App\Contracts\AiClientContract;
use App\DTO\AiCommandDto;
use App\DTO\AiResultDto;

class AiService
{
    public function __construct(
        protected AiClientContract $client,
    ) {}

    public function generateGreeting(): AiResultDto
    {
        return $this->client->generate(
            new AiCommandDto(
                prompt: 'Generate a welcome message for John',
                identity: 'You are a helpful AI consultant called Bobby, your job is to create welcome messages.',
            ),
        );
    }
}
