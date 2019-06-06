<?php

use Mdixon18\MediaLibrary\Http\Controllers\MediaLibraryController;

Route::get('download/{mediaItem}', [MediaLibraryController::class , 'download' ]);