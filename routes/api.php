<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\getData;

Route::prefix('api')->group(function () {
    Route::post('functions', [getData::class, 'getFunction']);
    Route::post('machines', [getData::class, 'getMachine']);
    Route::post('body-parts', [getData::class, 'getBodyPart']);
});