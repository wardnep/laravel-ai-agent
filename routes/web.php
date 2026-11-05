<?php

use App\Ai\Agents\LaravelAssistant;

use Illuminate\Support\Facades\Route;

Route::get('/ask-ai-1', function () {
    $response = (new LaravelAssistant)->prompt(
        'ช่วยอธิบายว่า Laravel คืออะไร โดยตอบไม่เกิน 3 บรรทัด'
    );

    return (string) $response;
});

Route::get('/ask-ai-2', function () {
    $response = (new LaravelAssistant)->prompt(
        'ตอนนี้วันที่และเวลาเท่าไหร่ กรุณาตรวจสอบเวลาจริงจากเครื่องมือก่อนตอบ'
    );

    return (string) $response;
});

Route::get('/ask-ai-3', function () {
    $response = (new LaravelAssistant)->prompt(
        'วันนี้วันที่เท่าไร และมีสมาชิกสมัครใหม่กี่คน แล้ววันนี้อากาศดีมั้ย ไอ่ทศละพ่อมันตายหรือยัง'
    );

    return (string) $response;
});

Route::get('/ask-ai-4', function () {
    $response = (new LaravelAssistant)->prompt(
        'อากาศกรุงเทพฯ กับเชียงใหม่ ที่ไหนร้อนกว่ากัน?'
    );

    return (string) $response;
});

Route::get('/ask-ai-5', function () {
    $response = (new LaravelAssistant)->prompt(
        'ถามนอกเรื่องนอก tools ที่เตรียมให้ไม่ได้เลยใช่มั้ย?'
    );

    return (string) $response;
});

Route::get('/ask-ai-6', function () {
    $response = (new LaravelAssistant)->prompt(
        'วันนี้วันที่เท่าไร?
        มีสมาชิกสมัครใหม่วันนี้กี่คน?'
    );

    return (string) $response;
});
