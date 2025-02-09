<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\UserManualController;
use App\Http\Controllers\SettingsController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\BillingReportController;

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    ])->group(function () {
        Route::get('/', [HomePage::class, 'index'])->name('pages-home');
        Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
        Route::post('/reading/{id}', [ReadingController::class, 'update'])->name('reading.update');
        Route::get('/reports/billing', [BillingReportController::class, 'index'])->name('reports.billing.index');
        Route::get('/reports/billing/create', [BillingReportController::class, 'create'])->name('reports.billing.create');
        Route::post('payments/store-one-time-invoice', [PaymentController::class, 'storeOneTimeInvoice'])->name('payments.store_one_time_invoice');
        Route::get('invoices/summary/{id}', [InvoicesController::class, 'summary'])->name('invoices.summary');
        Route::get('invoices/one_time', [InvoicesController::class, 'one_time'])->name('invoices.one_time');
        Route::get('invoices/print-one-time-invoice/{id}', [InvoicesController::class, 'oneTimeInvoice'])->name('invoices.oneTimeInvoice');
        Route::get('invoices/print/{id}', [InvoicesController::class, 'print'])->name('invoices.print');
        Route::post('invoices/filter', [InvoicesController::class, 'filter'])->name('invoices.filter');
        Route::post('invoices/multiple_invoices', [InvoicesController::class, 'multiple']);
        Route::post('invoices/print_all_one_time_invoice', [InvoicesController::class, 'print_all_one_time_invoice']);
        Route::get('/invoices/specific_month', [InvoicesController::class, 'specific_month'])->name('invoices.specific_month');
        Route::get('/readings/filter', [ReadingController::class, 'specific_month'])->name('readings.specific_month');

        Route::get('settings/deleteUser/{id}', [SettingsController::class, 'deleteUser'])->name('settings.deleteUser');
        Route::get('settings/deleteRole/{id}', [SettingsController::class, 'deleteRole'])->name('settings.deleteRole');
        Route::get('settings/editDepartment/{id}', [SettingsController::class, 'editDepartment'])->name('settings.editDepartment');
        
        Route::get('/support', function(){
            return view('documentation.support');
        });
        
        Route::resources([
            'alerts' => AlertController::class,
            'categories' => CategoryController::class,
            'customers' => CustomerController::class,
            'readings' => ReadingController::class,
            'invoices' => InvoicesController::class,
            'locations' => LocationController::class,
            'meters' => MeterController::class,
            'payments' => PaymentController::class,
            'roles' => RoleController::class,
            'tariffs' => TariffController::class,
            'types' => TypeController::class,
            'analytics' => ReportController::class,
            'documentation' => UserManualController::class,
            'settings' => SettingsController::class,
        ]);
    // Route::middleware(['role:admin'])->group(function () {
    // });
        
});