<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\C_Master;
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

Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/', [AuthenticatedSessionController::class, 'create'])
            ->name('loginPage');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->name('login');

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.update');

// Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
//             ->name('logout');

Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
            
Route::get('/dashboard', [C_Master::class, 'ViewDashboard'])->name('dashboard');

//route get halaman master
Route::get('/barang', [C_Master::class, 'ViewMasterBarang'])
        ->name('barang');
Route::get('/kategori', [C_Master::class, 'ViewMasterKategori'])
        ->name('kategori');
Route::get('/pegawai', [C_Master::class, 'ViewMasterUser'])
        ->name('pegawai');
Route::get('/stok', [C_Master::class, 'ViewMasterStok'])
        ->name('stok');
Route::get('/member', [C_Master::class, 'ViewMasterMember'])
        ->name('member');
Route::get('/promo', [C_Master::class, 'ViewMasterPromo'])
        ->name('dashboard');

require __DIR__.'/auth.php';

// ->middleware(['auth', 'verified'])

// [
//     'canLogin' => Route::has('login'),
//     'canRegister' => Route::has('register'),
//     'laravelVersion' => Application::VERSION,
//     'phpVersion' => PHP_VERSION,
// ]
