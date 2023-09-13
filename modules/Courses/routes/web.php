<?php

use Illuminate\Support\Facades\Route;
use Modules\Courses\src\Http\Controllers\CoursesController;

Route::group(['namespace' => 'Modules\Courses\src\Http\Controller'], function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('/courses')->group(function () {
            Route::get('/', [CoursesController::class, 'index'])->name('admin.courses.index');
            Route::get('/data', [CoursesController::class, 'data'])->name('admin.courses.data');

            Route::get('/create', [CoursesController::class, 'create'])->name('admin.courses.create');
            Route::post('/create', [CoursesController::class, 'store'])->name('admin.courses.store');

            Route::get('/edit/{course}', [CoursesController::class, 'edit'])->name('admin.courses.edit');
            Route::put('/update/{id}', [CoursesController::class, 'update'])->name('admin.courses.update');

            Route::delete('/delete/{id}', [CoursesController::class, 'delete'])->name('admin.courses.delete');
        });
    });
});

Route::group(['prefix' => 'filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
