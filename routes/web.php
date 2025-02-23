<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlacedStudentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TrainerMiddleware;

// Login Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::middleware(['guest'])->group(function () {
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'index'])->name('dashboard.search');
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    // Password Change Routes
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.update-change');

    // Donor Routes
    Route::prefix('donors')->group(function () {
        // Public donor routes
        Route::get('/', [DonorController::class, 'index'])->name('donors.index');
        
        // Admin only donor routes
        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/create', [DonorController::class, 'create'])->name('donors.create');
            Route::post('/', [DonorController::class, 'store'])->name('donors.store');
            Route::get('/{donor}/edit', [DonorController::class, 'edit'])->name('donors.edit');
            Route::put('/{donor}', [DonorController::class, 'update'])->name('donors.update');
            Route::delete('/{donor}', [DonorController::class, 'destroy'])->name('donors.destroy');
        });

        // This must come after /create to avoid route conflicts
        Route::get('/{donor}', [DonorController::class, 'show'])->name('donors.show');
    });

    // View and Export routes for all authenticated users
    Route::group([], function () {
        // Student Routes (View Only)
        Route::prefix('students')->controller(StudentController::class)->group(function () {
            Route::get('/', 'index')->name('students.index');
            Route::get('/view/{student}', 'show')->name('students.show');
        });
        
        // Document Routes (View Only)
        Route::prefix('documents')->controller(StudentDocumentController::class)->group(function () {
            Route::get('/{document}/download', 'download')->name('documents.download');
            Route::get('/student/{student}', 'index')->name('student.documents.view');
        });

        // Graduate Routes (View Only)
        Route::prefix('graduates')->controller(GraduateController::class)->group(function () {
            Route::get('/', 'index')->name('graduates.index');
            Route::get('/view/{graduate}', 'show')->name('graduates.show');
        });

        // Placement Routes (View Only)
        Route::controller(PlacedStudentController::class)->group(function () {
            Route::get('/placements', 'index')->name('placements.index');
            Route::get('/placements/view/{placedStudent}', 'show')->name('placements.show');
        });
        
        // Data Management Routes
        Route::prefix('data')->group(function () {
                Route::get('/management', [DataManagementController::class, 'index'])->name('data-management');
                Route::get('/export/students', [DataManagementController::class, 'exportStudents'])->name('data.export.students');
                Route::get('/export/graduates', [DataManagementController::class, 'exportGraduates'])->name('data.export.graduates');
                Route::get('/export/placements', [DataManagementController::class, 'exportPlacements'])->name('data.export.placements');
                Route::get('/download/{id}', [DataManagementController::class, 'download'])->name('data.download');
            });

        // Export Routes
        Route::prefix('export')->group(function () {
                Route::get('/', [ExportController::class, 'index'])->name('export.index');
                Route::get('/students', [DataManagementController::class, 'exportStudents'])->name('export')->defaults('type', 'students');
                Route::get('/graduates', [ExportController::class, 'export'])->name('export.graduates')->defaults('type', 'graduates');
                Route::get('/placements', [ExportController::class, 'export'])->name('export.placements')->defaults('type', 'placements');
                Route::get('/all', [ExportController::class, 'exportAll'])->name('export.all');
            });

        // Dashboard Export
        Route::get('/dashboard/export', [DashboardController::class, 'exportAll'])->name('dashboard.export');
    });

    // Test route for middleware
    Route::get('/test-trainer', function() {
        return 'Trainer middleware is working!';
    })->middleware(['auth', 'trainer'])->name('test.trainer');

    // Trainer & Admin Routes (CRUD Access)
    Route::middleware('trainer')->group(function () {
        // Student Management CRUD
        Route::prefix('students')->controller(StudentController::class)->group(function () {
            Route::get('/create', 'create')->name('students.create');
            Route::post('/', 'store')->name('students.store');
            Route::get('/{student}/edit', 'edit')->name('students.edit');
            Route::put('/{student}', 'update')->name('students.update');
            Route::delete('/{student}', 'destroy')->name('students.destroy');
            
            // Document Management
            Route::prefix('{student}/documents')->controller(StudentDocumentController::class)->group(function () {
                Route::post('/', 'store')->name('students.documents.store');
                Route::post('/{document}/verify', 'verify')->name('student.documents.verify');
                Route::post('/{document}/reject', 'reject')->name('student.documents.reject');
                Route::delete('/{document}', 'destroy')->name('student.documents.destroy');
            });
        });

        // Graduate Management CRUD
        Route::prefix('graduates')->controller(GraduateController::class)->group(function () {
            Route::get('/create', 'create')->name('graduates.create');
            Route::post('/', 'store')->name('graduates.store');
            Route::get('/{graduate}/edit', 'edit')->name('graduates.edit');
            Route::put('/{graduate}', 'update')->name('graduates.update');
            Route::delete('/{graduate}', 'destroy')->name('graduates.destroy');
        });

        // Placement Management CRUD
        Route::prefix('placements')->controller(PlacedStudentController::class)->group(function () {
            Route::get('/create', 'create')->name('placements.create');
            Route::post('/', 'store')->name('placements.store');
            Route::get('/{placedStudent}/edit', 'edit')->name('placements.edit');
            Route::put('/{placedStudent}', 'update')->name('placements.update');
            Route::delete('/{placedStudent}', 'destroy')->name('placements.destroy');
        });

        // Document Management Routes
        Route::get('/students/{student}/documents', [StudentDocumentController::class, 'index'])->name('student.documents.manage');
        Route::post('/students/{student}/documents', [StudentDocumentController::class, 'store'])->name('students.documents.store');
        Route::get('/documents/{document}/download', [StudentDocumentController::class, 'download'])->name('documents.download');
        Route::post('/documents/{document}/verify', [StudentDocumentController::class, 'verify'])->name('documents.verify.manage');
        Route::post('/documents/{document}/reject', [StudentDocumentController::class, 'reject'])->name('documents.reject.manage');
        Route::delete('/documents/{document}', [StudentDocumentController::class, 'destroy'])->name('documents.destroy.manage');

        // Export Routes
        Route::prefix('export')->group(function () {
            Route::get('/', [ExportController::class, 'index'])->name('export.index');
            Route::get('/students', [DataManagementController::class, 'exportStudents'])->name('export')->defaults('type', 'students');
            Route::get('/graduates', [ExportController::class, 'export'])->name('export.graduates')->defaults('type', 'graduates');
            Route::get('/placements', [ExportController::class, 'export'])->name('export.placements')->defaults('type', 'placements');
            Route::get('/all', [ExportController::class, 'exportAll'])->name('export.all');
        });
    });

    // Admin Only Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // User Management Routes
        Route::resource('users', UserController::class)->except(['show']);

        // Activity Logs Routes
        Route::controller(ActivityLogController::class)->group(function () {
            Route::get('/activity-logs', 'index')->name('activity-logs.index');
            Route::get('/activity-logs/export/csv', 'export')->name('activity-logs.export');
            Route::get('/activity-logs/{log}', 'show')->name('activity-logs.show');
        });
    });
});
