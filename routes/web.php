<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [\App\Http\Controllers\Controller::class, 'index'])->name('home');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group( function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login.form');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.user');
    Route::get('/register', [RegisterController::class, 'index'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store'])->name('store.user');
});

Route::middleware(['auth'])->group( function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/expense', [ExpenseController::class, 'index'])->name('user.expenses');
    Route::post('/dashboard/expense', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/dashboard/expense/filter', [ExpenseController::class, 'index'])->name('filter.expense');
    Route::get('/dashboard/budget', [BudgetController::class, 'index'])->name('user.budget');
    Route::post('/dashboard/budget', [BudgetController::class, 'store'])->name('budget.store');
    Route::patch('/dashboard/budget/{id}', [BudgetController::class, 'update'])->name('budget.update');
    Route::delete('/dashboard/budget/{id}', [BudgetController::class, 'destroy'])->name('budget.delete');

    Route::get('/dashboard/generate-report', [ExpenseController::class, 'generateReport'])->name('generate.report');
});

Route::middleware(['admin'])->group( function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('category.create');
    Route::post('/admin/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');


    Route::get('/admin/users', [AdminDashboardController::class, 'UserDetails'])->name('user.details');
    Route::delete('/admin/users/{id}', [AdminDashboardController::class, 'DeleteUser'])->name('user.delete');
    Route::patch('/admin/users/{id}', [AdminDashboardController::class, 'UpdateUser'])->name('user.update');


    Route::get('/admin/permission', [AdminDashboardController::class, 'permissions'])->name('permission');


});
