<?php

namespace App\Ai\Tools;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetUserById implements Tool
{
    public function description(): Stringable|string
    {
        return 'Find a user by their ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $userId = $request['user_id'];

        $user = User::find($userId);

        if (! $user) {
            return 'User not found.';
        }

        return json_encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'user_id' => $schema->integer()
                ->description('The ID of the user to find.')
                ->required(),
        ];
    }
}
