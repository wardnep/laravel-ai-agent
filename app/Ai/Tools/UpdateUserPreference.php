<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class UpdateUserPreference implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Update a user preference.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $key = $request['key'];
        $value = $request['value'];

        // Allow only supported preferences
        $allowed = [
            'language' => ['th', 'en'],
            'answer_style' => ['concise', 'detailed'],
        ];

        if (!isset($allowed[$key])) {
            return 'This preference is not supported.';
        }

        if (!in_array($value, $allowed[$key], true)) {
            return 'Invalid preference value.';
        }

        // Get the authenticated user from Laravel
        $user = auth()->user();

        if (!$user) {
            return 'User is not authenticated.';
        }

        // Save preference
        $user->preferences()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        return "Preference {$key} updated successfully.";
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'key' => $schema->string()->required(),
            'value' => $schema->string()->required(),
        ];
    }
}
