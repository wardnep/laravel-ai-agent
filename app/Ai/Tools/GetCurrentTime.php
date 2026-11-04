<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetCurrentTime implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get the current date and time in the server timezone.';
    }

    public function handle(Request $request): Stringable|string
    {
        return now()->format('Y-m-d H:i:s');
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
