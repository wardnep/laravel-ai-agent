<?php

use App\Ai\Agents\LaravelAssistant;

use Illuminate\Support\Facades\Route;

Route::get('/ask-ai', function () {
    $response = (new LaravelAssistant)->prompt(
        'ช่วยอธิบายว่า Laravel คืออะไร โดยตอบไม่เกิน 3 บรรทัด'
    );

    return (string) $response;
});
