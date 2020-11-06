<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');

URL::forceScheme('https');