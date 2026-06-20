<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $productModel = new Product();
        $saleModel = new Sale();
        $expenseModel = new Expense();
        $debtModel = new Debt();

        $totalSales = $saleModel->totalSales();
        $cogs = $saleModel->costOfGoodsSold();
        $totalExpenses = $expenseModel->total();
        $grossProfit = $totalSales - $cogs;
        $netProfit = $grossProfit - $totalExpenses;

        $this->view('dashboard/index', [
            'pageTitle'      => 'Dashboard',
            'totalSales'     => $totalSales,
            'totalExpenses'  => $totalExpenses,
            'grossProfit'    => $grossProfit,
            'netProfit'      => $netProfit,
            'productCount'   => $productModel->count(),
            'lowStock'       => $productModel->lowStock(),
            'expiringSoon'   => $productModel->expiringSoon(),
            'expired'        => $productModel->expired(),
            'totalDebt'      => $debtModel->totalOutstanding(),
            'todaySales'     => $saleModel->dailyTotal(),
        ]);
    }
}
