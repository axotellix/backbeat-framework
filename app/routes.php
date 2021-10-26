<?php

// [ IMPORTS ]
namespace Backbeat;
use Backbeat\Route;


// [ ROUTES ]
Route::get('/', 'HomeController@index');
Route::get('/about', function() {
    return view('pages/about');
});
Route::get('/create', function() {
    return view('pages/create');
});
Route::post('/create', 'ImageController@store');


?> 