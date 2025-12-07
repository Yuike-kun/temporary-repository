<?php

use App\Enum\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BengkelController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminBengkelController;
use App\Http\Controllers\BengkelServiceController;
use App\Http\Controllers\ServiceRequestController;

// Authentication
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('registerProcess');
});
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Guest Route
Route::view('/', 'landing.index')->name('landing');
Route::get('/bengkels', [BengkelController::class, 'grid'])->name('bengkels.grid');
Route::get('/bengkels/{bengkel}', [BengkelController::class, 'show'])->name('bengkels.show');

// Dashboard Redirect
Route::redirect('/dashboards', '/dashboard-redirect');
Route::get('/dashboard-redirect', function () {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        UserRole::ADMIN   => redirect('/dashboard/admin'),
        UserRole::BENGKEL => redirect('/dashboard/bengkel'),
        UserRole::PUBLIC  => redirect('/dashboard/public'),
        default           => abort(403, 'Unauthorized'),
    };
})->middleware('auth')->name('dashboard');

// Admin
Route::prefix('dashboard/admin')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('akun/admin')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.akun');
    Route::get('/create', [UserController::class, 'create'])->name('admin.create');
    Route::post('/store', [UserController::class, 'store'])->name('admin.store');
    Route::get('/edit/{akun}', [UserController::class, 'edit'])->name('admin.edit');
    Route::put('/update/{akun}', [UserController::class, 'update'])->name('admin.update');
    Route::delete('delete/{akun}', [UserController::class, 'destroy'])->name('admin.destroy');
});

Route::prefix('akun/pengguna')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/store', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/edit/{pengguna}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/update/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/delete/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
});

Route::prefix('akun/admin-bengkel')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', [AdminBengkelController::class, 'index'])->name('admin-bengkel.index');
    Route::get('/create', [AdminBengkelController::class, 'create'])->name('admin-bengkel.create');
    Route::post('/store', [AdminBengkelController::class, 'store'])->name('admin-bengkel.store');
    Route::get('/edit/{adminBengkel}', [AdminBengkelController::class, 'edit'])->name('admin-bengkel.edit');
    Route::put('/update/{adminBengkel}', [AdminBengkelController::class, 'update'])->name('admin-bengkel.update');
    Route::delete('/delete/{adminBengkel}', [AdminBengkelController::class, 'destroy'])->name('admin-bengkel.destroy');
});

Route::prefix('bengkel')->as('bengkel.')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::prefix('list')->as('list.')->group(function () {
        Route::get('/', [BengkelController::class, 'index'])->name('index');
        Route::get('/create', [BengkelController::class, 'create'])->name('create');
        Route::post('/store', [BengkelController::class, 'store'])->name('store');
        Route::get('/edit/{bengkel}', [BengkelController::class, 'edit'])->name('edit');
        Route::put('/update/{bengkel}', [BengkelController::class, 'update'])->name('update');
        Route::delete('/delete/{bengkel}', [BengkelController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('map')->as('map.')->group(function () {
        Route::get('/', [BengkelController::class, 'indexMap'])->name('index');
    });
});

Route::prefix('service')->as('service.')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/store', [ServiceController::class, 'store'])->name('store');
    Route::get('/edit/{service}', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/update/{service}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/delete/{service}', [ServiceController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/bengkel-services')->as('admin.bengkel-services.')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', [BengkelServiceController::class, 'index'])->name('index');
    Route::get('/{bengkel}/manage', [BengkelServiceController::class, 'manage'])->name('manage');
    Route::put('/{bengkel}/update', [BengkelServiceController::class, 'update'])->name('update');
});

// Public User
Route::prefix('dashboard/public')->middleware(['auth', 'role:PUBLIC'])->group(function () {
    Route::get('/', fn() => view('dashboard.user.index'));
});

// Service Requests for Public Users
Route::prefix('service-requests')->as('service-requests.')->middleware(['auth', 'role:PUBLIC'])->group(function () {
    Route::get('/bengkels', [ServiceRequestController::class, 'index'])->name('index');
    Route::get('/bengkels/{bengkel}', [ServiceRequestController::class, 'show'])->name('show');
    Route::get('/bengkels/{bengkel}/request', [ServiceRequestController::class, 'create'])->name('create');
    Route::post('/bengkels/{bengkel}/request', [ServiceRequestController::class, 'store'])->name('store');
    Route::get('/my-requests', [ServiceRequestController::class, 'myRequests'])->name('my-requests');
    Route::patch('/{serviceRequest}/cancel', [ServiceRequestController::class, 'cancel'])->name('cancel');
});

// Admin Bengkel
Route::prefix('dashboard/bengkel')->middleware(['auth', 'role:BENGKEL'])->group(function () {
    Route::get('/', fn() => view('dashboard.bengkel.index'));
});

// Service Requests for Bengkel
Route::prefix('bengkel/service-requests')->as('bengkel.service-requests.')->middleware(['auth', 'role:BENGKEL'])->group(function () {
    Route::get('/', [ServiceRequestController::class, 'bengkelRequests'])->name('index');
    Route::get('/{serviceRequest}', [ServiceRequestController::class, 'bengkelRequestDetail'])->name('show');
    Route::patch('/{serviceRequest}/update-status', [ServiceRequestController::class, 'updateStatus'])->name('update-status');
});
