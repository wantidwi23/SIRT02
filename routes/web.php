<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\LetterCategoryController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\GeminiConfigController;
use App\Http\Controllers\HeadOfFamilyController;

Route::get('/', [PublicNewsController::class, 'homepage'])->name('index');

// Public News Routes
Route::get('/berita', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard Route (accessible for authenticated users and head_of_family session)
Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard')->middleware('user');

// Password Change Routes (accessible for authenticated users and head_of_family session)
Route::get('/password/change', [AuthController::class, 'showChangePassword'])->name('password.change')->middleware('user');
Route::post('/password/change', [AuthController::class, 'updatePassword'])->name('password.update')->middleware('user');

// User Routes (for both authenticated users and head_of_family session)
Route::middleware('user')->group(function () {
    // User can only view residents (index, show)
    Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
    Route::get('/residents/{resident}', [ResidentController::class, 'show'])->name('residents.show');
    Route::get('/residents/search', [ResidentController::class, 'search'])->name('residents.search');
    
    // User can create reports and view/list them (but not edit, update, delete)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    
    // User can CRUD letters
    Route::resource('letters', LetterController::class);
    
    // Chatbot Routes - Only for users
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/api/chatbot/message', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
    Route::get('/api/chatbot/conversation', [ChatbotController::class, 'getConversation'])->name('chatbot.get');
    Route::post('/api/chatbot/clear', [ChatbotController::class, 'clearConversation'])->name('chatbot.clear');
});

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        
        // Admin can manage all resources
        Route::resource('residents', ResidentController::class);
        Route::get('/residents/search', [ResidentController::class, 'search'])->name('residents.search');
        Route::get('/residents/import/show', [ResidentController::class, 'importShow'])->name('residents.import-show');
        Route::post('/residents/import', [ResidentController::class, 'import'])->name('residents.import');
        Route::get('/residents/download/template', [ResidentController::class, 'downloadTemplate'])->name('residents.download-template');
        // Admin can only view and update reports (not create), and delete
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
        Route::resource('letters', LetterController::class);
        Route::resource('letter-categories', LetterCategoryController::class);
        Route::resource('head-of-families', HeadOfFamilyController::class);
        Route::get('/head-of-families/import/template', [HeadOfFamilyController::class, 'importTemplate'])->name('head-of-families.import-template');
        Route::post('/head-of-families/import', [HeadOfFamilyController::class, 'import'])->name('head-of-families.import');
        Route::resource('news', NewsController::class);
        Route::resource('gemini-configs', GeminiConfigController::class);
        Route::post('/gemini-configs/{geminiConfig}/set-active', [GeminiConfigController::class, 'setActive'])->name('gemini-configs.set-active');
        Route::post('/gemini-configs/{geminiConfig}/test-connection', [GeminiConfigController::class, 'testConnection'])->name('gemini-configs.test-connection');
    });
});

