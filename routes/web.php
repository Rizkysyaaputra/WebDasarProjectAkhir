<?php
use App\Http\Controllers\CipherController;

Route::get('/', function () {
    return view('cipher');
});

Route::post('/encrypt', [CipherController::class, 'encrypt'])->name('encrypt');
