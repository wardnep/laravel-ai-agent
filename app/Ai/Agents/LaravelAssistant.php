<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Promptable;
use Laravel\Ai\Concerns\RemembersConversations;

use Stringable;

use App\Ai\Tools\GetCurrentTime;
use App\Ai\Tools\GetUserStatistics;
use App\Ai\Tools\GetWeather;
use App\Ai\Tools\UpdateUserPreference;
use App\Ai\Tools\GetUserById;

class LaravelAssistant implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a helpful assistant. Always respond in Thai.';
    }

    /**
     * Get the tools available to the agent.
     *
     * @return list<Agent|Tool|ProviderTool>
     */
    public function tools(): iterable
    {
        return [
            new GetCurrentTime(),
            new GetUserStatistics(),
            new GetWeather(),
            new UpdateUserPreference(),
            new GetUserById(),
        ];
    }
}
