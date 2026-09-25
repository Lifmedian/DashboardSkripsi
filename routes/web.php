<?php

use Illuminate\Support\Facades\Route;

// Halaman Dashboard (Home)
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Halaman Dashboard (Home)
Route::get('/eksploratif', function () {
    return view('pages.eksploratif');
})->name('eksploratif');

// Halaman Dashboard (Home)
Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

// Halaman Dashboard (Home)
Route::get('/spasial', function () {
    return view('pages.spasial');
})->name('spasial');

// Halaman Dashboard (Home)
Route::get('/proses-estimasi-sae', function () {
    return view('pages.sae');
})->name('sae');