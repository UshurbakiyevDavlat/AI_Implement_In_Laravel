<?php

namespace App\Enums;

enum AiContextRole: string
{
    case System = 'system';
    case User = 'user';
    case Assistant = 'assistant';
}
