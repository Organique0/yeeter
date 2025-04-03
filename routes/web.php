<?php

use App\Livewire\DisplayPosts;
use App\Livewire\PersonalPosts;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('home', 'home')
    ->middleware(['auth', 'verified'])
    ->name('home');

/* Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile'); */

Route::view('settings', 'settings')
    ->middleware(['auth'])
    ->name('settings');

Route::get('/u/{username}', PersonalPosts::class)->middleware(['auth', 'verified'])->name('user.posts');
require __DIR__ . '/auth.php';
