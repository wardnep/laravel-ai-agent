<?php

use App\Ai\Agents\LaravelAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/ask-ai', function (Request $request) {

    $validated = $request->validate([
        'message' => ['required', 'string', 'max:10000'],
    ]);

    $response = (new LaravelAssistant)->prompt(
        $validated['message']
    );

    return response()->json([
        'answer' => (string) $response,
    ]);
});
