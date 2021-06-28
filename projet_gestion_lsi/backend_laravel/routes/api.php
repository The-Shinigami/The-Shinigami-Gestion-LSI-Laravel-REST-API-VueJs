<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\reservationController;
use App\Http\Controllers\noteController;
use App\Http\Controllers\etudiantController;
use App\Http\Controllers\profController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\emploiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [authController::class, 'login']);

//admin
Route::middleware(['auth.guard:admin-api'])->group(function () {
    Route::get('/reservationadmin', [adminController::class, 'getReservationAdmin']);
    Route::post('/reservationadmin', [adminController::class, 'saveReservationAdmin']);
    Route::get('/emploi/admin', [adminController::class, 'getEmploiAdmin']);
    Route::post('/addetudiant', [adminController::class, 'addEtudiant']);
    Route::put('/updateetudiant', [adminController::class, 'updateEtudiant']);
    Route::delete('/deleteetudiant', [adminController::class, 'deleteEtudiant']);
    Route::get('/getalletudiant', [adminController::class, 'getAllEtudiant']);  
    Route::get('/getallpfe', [adminController::class, 'getAllPfe']);
    Route::post('/setpfeadmin', [adminController::class, 'setPfe']);
    Route::get('/getpfeadmin', [adminController::class, 'getPfeAdmin']);
    Route::put('/updatepfe', [adminController::class, 'updatePfe']);
    Route::delete('/deletepfe', [adminController::class, 'deletePfe']);
    Route::get('/getemploi', [adminController::class, 'getEmploi']);
    Route::put('/updateemploi', [adminController::class, 'UpdateEmploi']);
  
});

//prof
Route::middleware(['auth.guard:prof-api'])->group(function () {
    Route::get('/noteprof', [profController::class, 'getNoteProf']);
    Route::get('/notificationprof', [profController::class, 'getNotificationProf']);
    Route::post('/noteprof/save', [profController::class, 'saveNoteProf']);
    Route::get('/reservationprof', [profController::class, 'getReservationProf']);
    Route::post('/reservationprof', [profController::class, 'saveReservationProf']);
    Route::get('/emploi/prof', [profController::class, 'getEmploiProf']);
    Route::get('/getpfeprof', [profController::class, 'getPfeProf']);
});


//etudiant
Route::middleware(['auth.guard:etudiant-api'])->group(function () {
    Route::get('/note', [etudiantController::class, 'getNoteEtudiant']);
    Route::get('/notificationetudiant', [etudiantController::class, 'getNotificationEtudiant']);
    Route::get('/emploi/etudiant', [etudiantController::class, 'getEmploiEtudiant']);
    Route::get('/getpfeetudiant', [etudiantController::class, 'getPfeEtudiant']);
    
});

