<?php
Route::group(['prefix' => config('daothanh-tinymce.file_manager'), 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
