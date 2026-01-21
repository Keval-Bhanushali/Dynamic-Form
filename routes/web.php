<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('forms', App\Http\Controllers\FormController::class);
Route::resource('forms.submissions', App\Http\Controllers\FormSubmissionController::class)->shallow();
Route::get('forms/{form}/submit', [App\Http\Controllers\FormSubmissionController::class, 'create'])->name('submission.create');
Route::resource('fields', App\Http\Controllers\FieldController::class);
Route::get('/submissions', [App\Http\Controllers\FormSubmissionController::class, 'index'])->name('submissions.index');