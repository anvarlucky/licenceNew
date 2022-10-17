<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\NewController;
use App\Http\Controllers\Client\ProjectController;
use App\Http\Controllers\Client\ExperticeController;
use App\Http\Controllers\Client\client\OrganizationController;
use App\Http\Controllers\Client\MountaineeringController;
use App\Http\Controllers\Client\DSQController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ShaffofProjectController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
//Route::match(['get','post'],'/login',[AuthController::class,'login']);
Auth::routes(['register' => false]);
//Route::get('/login',[LoginController::class, 'logout']);
Route::match(['get','post'],'dsq410',[DSQController::class,'mountaineering']);
Route::match(['get','post'],'dsq381',[DSQController::class,'projects']);
Route::match(['get','post'],'dsqOrgs',[DSQController::class,'organizations']);
Route::get('projectsAll/send',[ProjectController::class,'allsend'])->name('ministry2222');
Route::resource('/organizations',OrganizationController::class);
Route::resource('projects', ProjectController::class)->middleware(['web', 'auth']);
//Vazirlik Buyrug`i Projects
Route::get('decisionget/{id}', [ProjectController::class,'decisionget'])->name('decisionget')->middleware(['web', 'auth']);
Route::put('decision/{id}', [ProjectController::class,'decision'])->name('decision')->middleware(['web', 'auth']);
//

//Vazirlik Buyrug`i Expertices
Route::get('decision1get/{id}', [ExperticeController::class,'decisionget'])->name('decision1get')->middleware(['web', 'auth']);
Route::put('decision1/{id}', [ExperticeController::class,'decision'])->name('decision1')->middleware(['web', 'auth']);
//
Route::get('projects.Inn',[ProjectController::class,'createNew'])->name('pra');
Route::get('projects.excel', [ProjectController::class,'export'])->name('export1');
Route::post('projects.search', [ProjectController::class,'search'])->name('projects.search');
Route::resource('expertice', ExperticeController::class)->middleware(['web', 'auth']);
Route::get('expertice.excel', [ExperticeController::class,'export'])->name('export2');
Route::post('expertice.search', [ExperticeController::class,'search'])->name('expertice.search');
Route::resource('mauntaineering', MountaineeringController::class)->middleware(['web', 'auth']);
Route::get('mauntaineering.excel', [MountaineeringController::class,'export'])->name('export3');
Route::post('mauntaineering.search', [MountaineeringController::class,'search'])->name('mauntaineering.search');
Route::resource('/', HomeController::class)->middleware(['web', 'auth']);
Route::group(['middleware' => ['web','auth'], 'prefix' => 'admin'], function (){
    Route::resource('announcements',AnnouncementController::class);
    Route::resource('shaffofprojects',ShaffofProjectController::class);
});

//NewController
Route::get('newbus',[NewController::class,'newbus']);
Route::post('newbus.search', [NewController::class,'search'])->name('newbus.search');
Route::get('newlic',[NewController::class,'newlic']);
Route::post('newlic.search', [NewController::class,'licsearch'])->name('newlic.search');
Route::get('newuniver',[NewController::class,'newuniver']);
Route::post('newuniver.search', [NewController::class,'universearch'])->name('newuniver.search');
Route::get('logout', [LoginController::class, 'logout']);
