<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CalenderEventController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\InvitationController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TrashController;

Route::name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');


    Route::post('/register', [RegisterController::class, 'store'])->name('register');
    Route::post('/login', [LoginController::class, 'store'])->name('login');
    Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth:sanctum');


    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');

    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');


    Route::get('/companies/trash', [TrashController::class, 'showTrash'])->name('ShowTrash');


    Route::middleware(['auth:sanctum', 'api.membership'])->prefix('c/{company:slug}')->scopeBindings()->group(function () {

        // Company routes
        Route::get('/', [CompanyController::class, 'show'])->name('companies.show');
        Route::post('/', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/', [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::post('/restore', [CompanyController::class, 'restore'])->name('companies.restore');
        Route::post('/force-delete', [CompanyController::class, 'forceDelete'])->name('companies.force-delete');

        // Calender event routes
        Route::get('/calender-events', [CalenderEventController::class, 'index'])->name('calender-events.index');
        Route::post('/calender-events', [CalenderEventController::class, 'store'])->name('calender-events.store');
        Route::get('/calender-events/{calenderEvent}', [CalenderEventController::class, 'show'])->name('calender-events.show');
        Route::post('/calender-events/{calenderEvent}', [CalenderEventController::class, 'update'])->name('calender-events.update');
        Route::delete('/calender-events/{calenderEvent}', [CalenderEventController::class, 'destroy'])->name('calender-events.destroy');
        Route::post('/calender-events/{calenderEvent}/restore', [CalenderEventController::class, 'restore'])->name('calender-events.restore');
        Route::post('/calender-events/{calenderEvent}/force-delete', [CalenderEventController::class, 'forceDelete'])->name('calender-events.force-delete');

        // Category routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::post('/categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');

        // Client routes
        Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
        Route::post('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::post('/clients/{client}/restore', [ClientController::class, 'restore'])->name('clients.restore');
        Route::post('/clients/{client}/force-delete', [ClientController::class, 'forceDelete'])->name('clients.force-delete');

        // Conversation routes
        Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
        Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
        Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
        Route::post('/conversations/{conversation}', [ConversationController::class, 'update'])->name('conversations.update');
        Route::delete('/conversations/{conversation}', [ConversationController::class, 'destroy'])->name('conversations.destroy');
        Route::post('/conversations/{conversation}/restore', [ConversationController::class, 'restore'])->name('conversations.restore');
        Route::post('/conversations/{conversation}/force-delete', [ConversationController::class, 'forceDelete'])->name('conversations.force-delete');

        // Invitation routes
        Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');  
        Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
        Route::get('/invitations/{invitation}', [InvitationController::class, 'show'])->name('invitations.show');
        Route::post('/invitations/{invitation}', [InvitationController::class, 'update'])->name('invitations.update');
        Route::delete('/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('invitations.destroy');
        Route::post('/invitations/{invitation}/restore', [InvitationController::class, 'restore'])->name('invitations.restore');
        Route::post('/invitations/{invitation}/force-delete', [InvitationController::class, 'forceDelete'])->name('invitations.force-delete');

        // Invoice routes
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::post('/invoices/{invoice}/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');
        Route::post('/invoices/{invoice}/force-delete', [InvoiceController::class, 'forceDelete'])->name('invoices.force-delete');

        // Membership routes
        Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
        Route::post('/memberships', [MembershipController::class, 'store'])->name('memberships.store');
        Route::get('/memberships/{membership}', [MembershipController::class, 'show'])->name('memberships.show');
        Route::post('/memberships/{membership}', [MembershipController::class, 'update'])->name('memberships.update');
        Route::delete('/memberships/{membership}', [MembershipController::class, 'destroy'])->name('memberships.destroy');
        Route::post('/memberships/{membership}/restore', [MembershipController::class, 'restore'])->name('memberships.restore');
        Route::post('/memberships/{membership}/force-delete', [MembershipController::class, 'forceDelete'])->name('memberships.force-delete');

        // Message routes
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
        Route::post('/messages/{message}/restore', [MessageController::class, 'restore'])->name('messages.restore');
        Route::post('/messages/{message}/force-delete', [MessageController::class, 'forceDelete'])->name('messages.force-delete');

        // Order routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('/orders/{order}/restore', [OrderController::class, 'restore'])->name('orders.restore');
        Route::post('/orders/{order}/force-delete', [OrderController::class, 'forceDelete'])->name('orders.force-delete');

        // Payment routes
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::post('/payments/{payment}/restore', [PaymentController::class, 'restore'])->name('payments.restore');
        Route::post('/payments/{payment}/force-delete', [PaymentController::class, 'forceDelete'])->name('payments.force-delete');

        // Permission routes
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
        Route::post('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        Route::post('/permissions/{permission}/restore', [PermissionController::class, 'restore'])->name('permissions.restore');
        Route::post('/permissions/{permission}/force-delete', [PermissionController::class, 'forceDelete'])->name('permissions.force-delete');

        // Product routes
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::post('/products/{product}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete');

        // Role routes
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::post('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::post('/roles/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore');
        Route::post('/roles/{role}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.force-delete');

        // Supplier routes
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
        Route::post('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        Route::post('/suppliers/{supplier}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore');
        Route::post('/suppliers/{supplier}/force-delete', [SupplierController::class, 'forceDelete'])->name('suppliers.force-delete');

        // Task routes
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::post('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::post('/tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
        Route::post('/tasks/{task}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.force-delete');

        // Trash Route

        Route::get('/trash', [TrashController::class, 'index'])->name('trash');
    });
});