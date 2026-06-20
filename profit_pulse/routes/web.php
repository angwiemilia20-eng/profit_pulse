<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use App\Controllers\DashboardController;
use App\Controllers\DebtController;
use App\Controllers\ExpenseController;
use App\Controllers\ProductController;
use App\Controllers\ReportController;
use App\Controllers\SaleController;
use App\Core\Router;

$router = new Router();

// Auth
$router->get('/', function () {
    echo "HOME ROUTE WORKS";
});
$router->get('login', [AuthController::class, 'loginForm']);
$router->post('login', [AuthController::class, 'login']);
$router->get('logout', [AuthController::class, 'logout']);

// Dashboard
$router->get('dashboard', [DashboardController::class, 'index']);

// Products
$router->get('products', [ProductController::class, 'index']);
$router->get('products/create', [ProductController::class, 'create']);
$router->post('products/store', [ProductController::class, 'store']);
$router->get('products/edit', [ProductController::class, 'edit']);
$router->post('products/update', [ProductController::class, 'update']);
$router->post('products/delete', [ProductController::class, 'delete']);
$router->get('products/expiry', [ProductController::class, 'expiry']);

// Sales
$router->get('sales', [SaleController::class, 'index']);
$router->get('sales/create', [SaleController::class, 'create']);
$router->post('sales/store', [SaleController::class, 'store']);

// Expenses
$router->get('expenses', [ExpenseController::class, 'index']);
$router->get('expenses/create', [ExpenseController::class, 'create']);
$router->post('expenses/store', [ExpenseController::class, 'store']);

// Customers
$router->get('customers', [CustomerController::class, 'index']);
$router->get('customers/create', [CustomerController::class, 'create']);
$router->post('customers/store', [CustomerController::class, 'store']);
$router->get('customers/show', [CustomerController::class, 'show']);
$router->get('customers/edit', [CustomerController::class, 'edit']);
$router->post('customers/update', [CustomerController::class, 'update']);
$router->post('customers/delete', [CustomerController::class, 'delete']);

// Debts
$router->get('debts', [DebtController::class, 'index']);
$router->get('debts/show', [DebtController::class, 'show']);
$router->post('debts/pay', [DebtController::class, 'pay']);

// Reports
$router->get('reports', [ReportController::class, 'index']);
$router->get('reports/sales', [ReportController::class, 'sales']);
$router->get('reports/inventory', [ReportController::class, 'inventory']);
$router->get('reports/profit', [ReportController::class, 'profit']);

return $router;
