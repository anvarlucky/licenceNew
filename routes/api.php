<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ExpeticeController;
use App\Http\Controllers\Api\MountaineeringController;
use App\Http\Controllers\Api\client\OrganizationController;
use App\Http\Controllers\Api\Admin\AnnouncementController;
use App\Http\Controllers\Api\Admin\ShaffofProjectController;


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
Route::apiResource('/orgs',OrganizationController::class);
Route::get('projects',[ProjectController::class,'index'])->name('projects');
Route::get('projectsReyting',[ProjectController::class,'indexReyting'])->name('projectsReyting');
Route::get('projectsAll/{sum?}/{search?}',[ProjectController::class,'all'])->name('projectsAll');
Route::post('projectsAll/{sum?}',[ProjectController::class,'all'])->name('projectsAll');
Route::get('projects/{inn?}',[ProjectController::class,'index'])->name('projects');
Route::post('projects/{inn?}',[ProjectController::class,'index'])->name('projects');
Route::get('expertice',[ExpeticeController::class,'index'])->name('expertice');
Route::get('experticeReyting',[ExpeticeController::class,'index'])->name('experticeReyting');
Route::post('expertice/{inn?}',[ExpeticeController::class,'index'])->name('expertice');
Route::get('experticeAll/{sum?}',[ExpeticeController::class,'all'])->name('experticeAll');
Route::get('expertice/{inn?}',[ExpeticeController::class,'index'])->name('expertice');
Route::get('mountaineering',[MountaineeringController::class,'index'])->name('mountaineering');
Route::get('mountaineeringAll/{sum?}/{cat}',[MountaineeringController::class,'all'])->name('mountaineeringAll');
Route::get('mountaineering/{inn?}',[MountaineeringController::class,'index'])->name('mountaineering');
Route::post('mountaineering/{inn?}',[MountaineeringController::class,'index'])->name('mountaineering');
Route::get('allExpertice', [ExpeticeController::class,'allExpertice'])->name('all');
/*Route::group(['prefix'=>'admin'],function (){
    Route::resource('announcements',AnnouncementController::class);
    Route::resource('shaffofprojects',ShaffofProjectController::class);
});*/
