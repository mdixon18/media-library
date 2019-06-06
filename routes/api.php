<?php
use Mdixon18\MediaLibrary\Http\Controllers\MediaLibraryController;

Route::post('upload', [ MediaLibraryController::class, 'upload' ]);
Route::post('delete', [ MediaLibraryController::class, 'delete' ]);
Route::post('save', [ MediaLibraryController::class, 'save' ]);
Route::get('media', [ MediaLibraryController::class, 'media' ]);