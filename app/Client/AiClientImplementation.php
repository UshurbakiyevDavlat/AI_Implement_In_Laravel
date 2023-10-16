<?php

namespace App\Client;

use App\Contracts\AiClientContract;
use App\DTO\AiCommandDto;
use App\DTO\AiContextDto;
use App\DTO\AiResultDto;
use App\Enums\AiContextRole;
use App\Exceptions\AiException;
use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI;
use OpenAI\Client;

use function Laravel\Prompts\error;

class AiClientImplementation implements AiClientContract
{
    protected Client $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.key'));
    }

    /**
     * @throws AiException
     */
    public function generate(AiCommandDto $dto): AiResultDto
    {
        $context = $this->prepareContext($dto->context);

        try {
            $result = $this->client->chat()->create([
                'model' => config('services.openai.model'),
                'messages' => [
                    $this->createContextArray(
                        new AiContextDto(
                            content: $dto->identity,
                            role: AiContextRole::System,
                        )
                    ),
                    ...$context,
                    $this->createContextArray(
                        new AiContextDto(
                            content: $dto->prompt,
                            role: AiContextRole::User,
                        )
                    ),
                ]
            ]);

            $output = str($result['choices'][0]['message']['content'] ?? '')
                ->replace("\n",  ' ')
                ->ltrim('.')
                ->trim()
                ->trim('"')
                ->toString();

            return new AiResultDto(
                output: $output,
                tokens: $result['usage']['total_tokens'],
            );
        } catch (Exception $e) {
            error($e->getMessage());
            Log::error('ai exception', ['trace' => $e->getTraceAsString()]);
            throw AiException::unknownException();
        }
    }

    protected function prepareContext(array $contextList): array
    {
        $output = [];

        /** @var AiContextDto $context */
        foreach ($contextList as $context) {
            $output[] = $this->createContextArray($context);
        }

        return $output;
    }

    protected function createContextArray(AiContextDto $dto): array
    {
        return [
            'role' => $dto->role->value,
            'content' => $dto->content,
        ];
    }
}
