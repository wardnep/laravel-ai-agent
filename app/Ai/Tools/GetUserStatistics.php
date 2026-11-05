<?php

namespace App\Ai\Tools;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;
use Log;

class GetUserStatistics implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get user statistics including total users, users registered today, and users registered this month.';
    }

    public function handle(Request $request): Stringable|string
    {
        Log::info('GetUserStatistics was called');

        $totalUsers = User::count();

        $todayUsers = User::whereDate(
            'created_at',
            today()
        )->count();

        $thisMonthUsers = User::where(
            'created_at',
            '>=',
            now()->startOfMonth()
        )->count();

        return json_encode([
            'total_users' => $totalUsers,
            'today_users' => $todayUsers,
            'this_month_users' => $thisMonthUsers,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
