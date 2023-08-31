<?php

use Illuminate\Support\Facades\Route;
use Modules\User\src\Http\Controllers\UserController;

// Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
//     Route::prefix('users')->name('users.')->group(function () {
//         Route::get('/', 'UserController@index')->name('index');

//         Route::get('data', 'UserController@data')->name('data');

//         Route::get('create', 'UserController@create')->name('create');

//         Route::post('create', 'UserController@store')->name('store');

//         Route::get('edit/{user}', 'UserController@edit')->name('edit');

//         Route::put('edit/{user}', 'UserController@update')->name('update');

//         Route::delete('delete/{user}', 'UserController@delete')->name('delete');
//     });
// });

Route::group(['namespace' => 'Modules\Users\src\Http\Controller'], function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('/data', [UserController::class, 'data'])->name('admin.users.data');

            Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
            Route::post('/create', [UserController::class, 'store'])->name('admin.users.store');

            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');

            Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
        });
    });
});
