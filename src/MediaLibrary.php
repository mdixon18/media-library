<?php

namespace Mdixon18\MediaLibrary;

use Illuminate\Support\Facades\Route;

class MediaLibrary
{
    /**
     * Scaffold routes for frontend usage
     */
    public static function routes()
    {
        Route::name('medialibrary.')->group(function () {
            require_once __DIR__.'/../routes/web.php';
        });
    }
}