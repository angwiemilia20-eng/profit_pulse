<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Sale;

class ReportController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $this->redirect('reports/sales');
    }

    public function sales(): void
    {
        $this->requireAuth();

        $saleModel = new Sale();
        $date = $_GET['date'] ?? date('Y-m-d');
        $year = (int) ($_GET['year'] ?? date('Y'));
        $month = (int) ($_GET['month'] ?? date('n'));

        $this->view('reports/sales', [
            'pageTitle'    => 'Sales Report',
            'dailySales'   => $saleModel->dailyReport($date),
            'monthlySales' => $saleModel->monthlyReport($year, $month),
            'dailyTotal'   => $saleModel->dailyTotal($date),
            'monthlyTotal' => $saleModel->monthlyTotal($year, $month),
            'date'         => $date,
            'year'         => $year,
            'month'        => $month,
        ]);
    }

    public function inventory(): void
    {
        $this->requireAuth();

        $productModel = new Product();

        $this->view('reports/inventory', [
            'pageTitle' => 'Inventory Report',
            'products'  => $productModel->all(),
            'lowStock'  => $productModel->lowStock(),
        ]);
    }

    public function profit(): void
    {
        $this->requireAuth();

        $saleModel = new Sale();
        $expenseModel = new Expense();

        $totalSales = $saleModel->totalSales();
        $cogs = $saleModel->costOfGoodsSold();
        $totalExpenses = $expenseModel->total();
        $grossProfit = $totalSales - $cogs;
        $netProfit = $grossProfit - $totalExpenses;

        $this->view('reports/profit', [
            'pageTitle'     => 'Profit Report',
            'totalSales'    => $totalSales,
            'cogs'          => $cogs,
            'grossProfit'   => $grossProfit,
            'totalExpenses' => $totalExpenses,
            'netProfit'     => $netProfit,
        ]);
    }
}
