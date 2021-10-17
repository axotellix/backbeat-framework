<?php

// [ IMPORTS ]
namespace Backbeat;
use Backbeat\Route;


// [ ROUTES ]
Route::get('/', 'HomeController@index');
Route::get('/about', function() {
    return view('pages/about');
});
// Route::get('/contacts', function() {
//     return view('pages/contacts');
// });


?> 