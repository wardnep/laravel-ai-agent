<?php
use App\Ai\Agents\LaravelAssistant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/ask-ai', function (Request $request) {

    $validated = $request->validate([
        'message' => ['required', 'string', 'max:10000'],
        'conversation_id' => ['nullable', 'string', 'uuid'],
    ]);

    // Demo: ใช้ User ID 15
    $user = User::findOrFail(15);

    $conversationId = $validated['conversation_id'] ?? null;

    // ตรวจสอบว่า Conversation เป็นของ User นี้
    if (
        $conversationId &&
        ! $user->conversations()->whereKey($conversationId)->exists()
    ) {
        return response()->json([
            'error' => 'Conversation not found.',
        ], 404);
    }

    $agent = new LaravelAssistant();

    if ($conversationId) {
        $agent = $agent->continue($conversationId, as: $user);
    } else {
        $agent = $agent->forUser($user);
    }

    $response = $agent->prompt($validated['message']);

    return response()->json([
        'answer' => (string) $response,
        'conversation_id' => $response->conversationId,
    ]);
});