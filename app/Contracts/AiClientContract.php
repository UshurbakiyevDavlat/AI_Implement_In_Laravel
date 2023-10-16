<?php

namespace App\Contracts;

use App\DTO\AiCommandDto;
use App\DTO\AiResultDto;

interface AiClientContract
{
    public function generate(AiCommandDto $dto): AiResultDto;
}
