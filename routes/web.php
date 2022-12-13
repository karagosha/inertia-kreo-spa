<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [HomeController::class, 'index_project'])->name('base.project.index');
Route::get('/projects/{project:slug}', [HomeController::class, 'show_project'])->name('base.project.show');
Route::get('job', [HomeController::class, 'index_job'])->name('base.job.index');
Route::get('job/{job}', [HomeController::class, 'show_job'])->name('base.job.show');



Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('employees', EmployeeController::class)->except(['show']);
    Route::resource('job', JobController::class)->except(['show']);
    Route::resource('feedback', FeedbackController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('item/update-weight', [AdminController::class, 'update_weight'])->name('update_weight');
});

Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'role:admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
