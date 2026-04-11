<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CalenderEventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->middleware('signed')->name('invitations.accept');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Root-level Company routes (for listing and creating companies)
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/trash', [TrashController::class, 'showTrash'])->name('ShowTrash');

    // Multi-tenant routes under a specific company
    Route::middleware(['membership'])->prefix('c/{company:slug}')->scopeBindings()->group(function () {
        
        // Company management
        Route::get('/', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::match(['post', 'put', 'patch'], '/', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/', [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::post('/restore', [CompanyController::class, 'restore'])->name('companies.restore');
        Route::post('/force-delete', [CompanyController::class, 'forceDelete'])->name('companies.force-delete');

        // Resources
        Route::resource('calender-events', CalenderEventController::class);
        Route::post('calender-events/{calenderEvent}/restore', [CalenderEventController::class, 'restore'])->name('calender-events.restore');
        Route::post('calender-events/{calenderEvent}/force-delete', [CalenderEventController::class, 'forceDelete'])->name('calender-events.force-delete');

        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::post('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');

        Route::resource('clients', ClientController::class);
        Route::post('clients/{client}/restore', [ClientController::class, 'restore'])->name('clients.restore');
        Route::post('clients/{client}/force-delete', [ClientController::class, 'forceDelete'])->name('clients.force-delete');

        Route::resource('conversations', ConversationController::class);
        Route::post('conversations/{conversation}/restore', [ConversationController::class, 'restore'])->name('conversations.restore');
        Route::post('conversations/{conversation}/force-delete', [ConversationController::class, 'forceDelete'])->name('conversations.force-delete');

        Route::resource('invitations', InvitationController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::post('invitations/send', [InvitationController::class, 'send'])->name('invitations.send');
        Route::post('invitations/{invitation}/restore', [InvitationController::class, 'restore'])->name('invitations.restore');
        Route::post('invitations/{invitation}/force-delete', [InvitationController::class, 'forceDelete'])->name('invitations.force-delete');

        Route::resource('invoices', InvoiceController::class);
        Route::post('invoices/{invoice}/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');
        Route::post('invoices/{invoice}/force-delete', [InvoiceController::class, 'forceDelete'])->name('invoices.force-delete');

        Route::resource('memberships', MembershipController::class);
        Route::post('memberships/{membership}/restore', [MembershipController::class, 'restore'])->name('memberships.restore');
        Route::post('memberships/{membership}/force-delete', [MembershipController::class, 'forceDelete'])->name('memberships.force-delete');

        Route::resource('messages', MessageController::class);
        Route::post('messages/{message}/restore', [MessageController::class, 'restore'])->name('messages.restore');
        Route::post('messages/{message}/force-delete', [MessageController::class, 'forceDelete'])->name('messages.force-delete');

        Route::resource('orders', OrderController::class);
        Route::post('orders/{order}/restore', [OrderController::class, 'restore'])->name('orders.restore');
        Route::post('orders/{order}/force-delete', [OrderController::class, 'forceDelete'])->name('orders.force-delete');

        Route::resource('payments', PaymentController::class);
        Route::post('payments/{payment}/restore', [PaymentController::class, 'restore'])->name('payments.restore');
        Route::post('payments/{payment}/force-delete', [PaymentController::class, 'forceDelete'])->name('payments.force-delete');

        Route::resource('permissions', PermissionController::class);
        Route::post('permissions/{permission}/restore', [PermissionController::class, 'restore'])->name('permissions.restore');
        Route::post('permissions/{permission}/force-delete', [PermissionController::class, 'forceDelete'])->name('permissions.force-delete');

        Route::resource('products', ProductController::class);
        Route::post('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::post('products/{product}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete');

        Route::resource('roles', RoleController::class);
        Route::post('roles/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore');
        Route::post('roles/{role}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.force-delete');

        Route::resource('suppliers', SupplierController::class);
        Route::post('suppliers/{supplier}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore');
        Route::post('suppliers/{supplier}/force-delete', [SupplierController::class, 'forceDelete'])->name('suppliers.force-delete');

        Route::resource('tasks', TaskController::class);
        Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
        Route::post('tasks/{task}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.force-delete');

        Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
    });
});

require __DIR__.'/auth.php';
