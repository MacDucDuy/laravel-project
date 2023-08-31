<?php 
 use Illuminate\Support\Facades\Route;

use Modules\Categories\src\Http\Controllers\CategoriesController;

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

Route::group(['namespace' => 'Modules\Categories\src\Http\Controller'], function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('/categories')->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('admin.categories.index');
            Route::get('/data', [CategoriesController::class, 'data'])->name('admin.categories.data');

            Route::get('/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
            Route::post('/create', [CategoriesController::class, 'store'])->name('admin.categories.store');

            Route::get('/edit/{category}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
            Route::put('/update/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');

            Route::delete('/delete/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');
        });
    });
});
