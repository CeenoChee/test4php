<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Bejelentkezés=====================================================================================================

    Route::get('bejelentkezes', [AuthController::class, 'showLoginForm'])->name('hu.login');
    Route::get('en/login', [AuthController::class, 'showLoginForm'])->name('en.login');
    Route::get('de/login', [AuthController::class, 'showLoginForm'])->name('de.login');

    Route::post('{locale}/login', [AuthController::class, 'login'])->name('login');

    // Regisztráció=====================================================================================================

    Route::get('regisztracio', [AuthController::class, 'showRegistrationForm'])->name('hu.register');
    Route::get('en/register', [AuthController::class, 'showRegistrationForm'])->name('en.register');
    Route::get('de/anmeldung', [AuthController::class, 'showRegistrationForm'])->name('de.register');

    Route::post('{locale}/register', [AuthController::class, 'register'])->name('register');

    Route::get('regisztracio/osszegzes', [AuthController::class, 'showRegistrationSummary'])->name('hu.register_summary');
    Route::get('en/register/summary', [AuthController::class, 'showRegistrationSummary'])->name('en.register_summary');
    Route::get('de/anmeldung/zusammenfassung', [AuthController::class, 'showRegistrationSummary'])->name('de.register_summary');

    Route::get('regisztracio/megerosites/{token}', [AuthController::class, 'confirm'])->name('hu.confirmation');
    Route::get('en/register/confirm/{token}', [AuthController::class, 'confirm'])->name('en.confirmation');
    Route::get('de/anmeldung/bestatigen/{token}', [AuthController::class, 'confirm'])->name('de.confirmation');

    // Jelszó visszaállítása=====================================================================================================

    Route::get('jelszo/visszaallitas', [PasswordController::class, 'showLinkRequestForm'])->name('hu.password.request');
    Route::get('en/password/reset', [PasswordController::class, 'showLinkRequestForm'])->name('en.password.request');
    Route::get('de/kennwort/rucksetzen', [PasswordController::class, 'showLinkRequestForm'])->name('de.password.request');

    Route::post('{locale}/password/reset', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('jelszo/visszaallitas/{token}', [PasswordController::class, 'reset'])->name('hu.password.reset');
    Route::get('en/password/reset/{token}', [PasswordController::class, 'reset'])->name('en.password.reset');
    Route::get('de/kennwort/rucksetzen/{token}', [PasswordController::class, 'reset'])->name('de.password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('kijelentkezes', [AuthController::class, 'logout'])->name('hu.logout');
    Route::get('en/logout', [AuthController::class, 'logout'])->name('en.logout');
    Route::get('de/aus', [AuthController::class, 'logout'])->name('de.logout');

    Route::get('fiok/jelszo', [PasswordController::class, 'showUpdateForm'])->name('hu.password.update');
    Route::get('en/account/password', [PasswordController::class, 'showUpdateForm'])->name('en.password.update');
    Route::get('de/account/password', [PasswordController::class, 'showUpdateForm'])->name('de.password.update');

    Route::post('{locale}/password/update/save', [PasswordController::class, 'update'])->name('password.update');
});
