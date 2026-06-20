<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    private Sale $sales;
    private Product $products;
    private Customer $customers;
    private Debt $debts;

    public function __construct()
    {
        $this->sales = new Sale();
        $this->products = new Product();
        $this->customers = new Customer();
        $this->debts = new Debt();
    }

    public function index(): void
    {
        $this->requireAuth();
        $this->view('sales/index', [
            'pageTitle' => 'Sales',
            'sales'     => $this->sales->all(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->view('sales/create', [
            'pageTitle' => 'Record Sale',
            'products'  => $this->products->inStock(),
            'customers' => $this->customers->all(),
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $paymentType = $_POST['payment_type'] ?? 'cash';
        $customerId = (int) ($_POST['customer_id'] ?? 0);
        $saleDate = $_POST['sale_date'] ?? date('Y-m-d');

        $product = $this->products->find($productId);

        if (!$product || $quantity <= 0) {
            flash('error', 'Invalid product or quantity.');
            $this->redirect('sales/create');
        }

        if ($quantity > $product['quantity']) {
            flash('error', 'Insufficient stock. Available: ' . $product['quantity']);
            $this->redirect('sales/create');
        }

        if ($paymentType === 'credit' && $customerId <= 0) {
            flash('error', 'Please select a customer for credit sales.');
            $this->redirect('sales/create');
        }

        $unitPrice = (float) $product['selling_price'];
        $totalAmount = $unitPrice * $quantity;

        $db = Database::connect();
        $db->beginTransaction();

        try {
            if (!$this->products->reduceStock($productId, $quantity)) {
                throw new \RuntimeException('Stock update failed.');
            }

            $saleId = $this->sales->create([
                'product_id'   => $productId,
                'customer_id'  => $paymentType === 'credit' ? $customerId : null,
                'quantity'     => $quantity,
                'unit_price'   => $unitPrice,
                'total_amount' => $totalAmount,
                'payment_type' => $paymentType,
                'sale_date'    => $saleDate,
            ]);

            if (!$saleId) {
                throw new \RuntimeException('Sale record failed.');
            }

            if ($paymentType === 'credit') {
                $debtId = $this->debts->create([
                    'customer_id'  => $customerId,
                    'sale_id'      => $saleId,
                    'amount_owed'  => $totalAmount,
                    'date_created' => $saleDate,
                ]);
                if (!$debtId) {
                    throw new \RuntimeException('Debt record failed.');
                }
            }

            $db->commit();
            flash('success', 'Sale recorded successfully.');
            $this->redirect('sales');
        } catch (\Throwable $e) {
            $db->rollBack();
            flash('error', 'Failed to record sale: ' . $e->getMessage());
            $this->redirect('sales/create');
        }
    }
}
