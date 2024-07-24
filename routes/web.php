<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\HealthHistoryMySQLController;

Route::controller(UserController::class)->group(function(){

     Route::get('/register','register');

     Route::get('/login','login')->name('login')->middleware('guest');


    Route::post('/login/process','process');

    Route::post('/logout','logout');

    Route::post('/store','store');

    Route::get('/users','index')->middleware('auth');

    Route::get('/user/{user}', 'show');

    Route::put('/user/{user}', 'update');

    Route::delete('/user/{user}', 'destroy')->name('user.destroy');

    Route::get('/users/search',  'search')->name('users.search');
});

Route::controller(AnimalController::class)->group(function() {
    Route::get('/patients', 'index')->middleware('auth')->name('patients.index');

    Route::get('/', 'showDashboard')->middleware('auth');

    Route::get('/add/animal', 'create')->name('animals.create');

    Route::post('/add/animal', 'store')->name('animals.store');

    Route::get('/animal/{animal}', 'show')->name('animals.show');

    Route::put('/animal/{animal}', 'update')->name('animals.update');

    Route::get('/showpdf/{animal}', 'showPdf')->name('animals.showPdf');

    Route::get('/animal/{animal}/detail', 'showDetail')->middleware('auth')->name('animal.detail');
Route::get('/get-breeds', [AnimalController::class, 'getBreeds'])->name('get.breeds');


    Route::delete('/animal/{animal}', 'destroy')->name('animal.destroy');

    Route::get('/animals/search', 'search')->name('animals.search');
});

Route::controller(SpeciesController::class)->group(function() {
    Route::get('/species', 'showSpecies')->middleware('auth');
    Route::get('/edit/{species}', 'show')->middleware('auth');
    Route::get('/add/species', 'create');
    Route::post('/add/species', 'store');
    Route::put('/edit/{species}', 'update');
    Route::delete('/species/{species}', 'destroy')->name('species.destroy');
    Route::get('/species/search', 'search')->name('species.search');
    Route::get('/species/breeds/{species}', 'showBreeds')->name('species.breeds');
    Route::get('/species/breeds/{species}/{breed}', 'showBreedDetails')->name('breed.details');
});



Route::controller(ConsultationController::class)->group(function(){
    Route::get('/consultation/{consultation}','showReview')->middleware('auth');

    Route::post('/add/review', 'storeExpertReview')->middleware('auth');
});


Route::controller(MonitoringController::class)->group(function(){

    Route::get('/monitoring', 'showTracking')->middleware('auth');

    Route::post('/monitoring', 'tracking')->middleware('auth')->name('monitoring.tracking');

    Route::get('/disconnect', 'disConnect')->name('disconnect');

    Route::post('/ongoing/{animal}', 'vitals')->name('ongoing');

    Route::get('/api/ongoing/{esp32}', 'dataFetchApi')->name('ongoing.api');


});


Route::controller(HealthHistoryMySQLController::class)->group(function(){

    Route::get('/health-history/{animal}', 'showHealthHistory')->name('animal.health-history');
    
});