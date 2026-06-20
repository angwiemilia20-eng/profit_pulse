<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    private Product $products;

    public function __construct()
    {
        $this->products = new Product();
    }

    public function index(): void
    {
        $this->requireAuth();
        $this->view('products/index', [
            'pageTitle' => 'Products',
            'products'  => $this->products->all(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->view('products/create', ['pageTitle' => 'Add Product']);
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $data = $this->validatedInput();
        if (!$this->products->create($data)) {
            flash('error', 'Failed to add product.');
            $this->storeOld($data);
            $this->redirect('products/create');
        }

        flash('success', 'Product added successfully.');
        $this->redirect('products');
    }

    public function edit(): void
    {
        $this->requireAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $product = $this->products->find($id);

        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('products');
        }

        $this->view('products/edit', [
            'pageTitle' => 'Edit Product',
            'product'   => $product,
        ]);
    }

    public function update(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $id = (int) ($_POST['product_id'] ?? 0);
        $product = $this->products->find($id);

        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('products');
        }

        $data = $this->validatedInput();
        if (!$this->products->update($id, $data)) {
            flash('error', 'Failed to update product.');
            $this->storeOld($data);
            $this->redirect('products/edit?id=' . $id);
        }

        flash('success', 'Product updated successfully.');
        $this->redirect('products');
    }

    public function delete(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $id = (int) ($_POST['product_id'] ?? 0);
        if ($this->products->delete($id)) {
            flash('success', 'Product deleted.');
        } else {
            flash('error', 'Could not delete product. It may be linked to sales.');
        }
        $this->redirect('products');
    }

    public function expiry(): void
    {
        $this->requireAuth();
        $this->view('products/expiry', [
            'pageTitle'    => 'Expiry Monitoring',
            'expiringSoon' => $this->products->expiringSoon(),
            'expired'      => $this->products->expired(),
        ]);
    }

    private function validatedInput(): array
    {
        $data = [
            'product_name'        => trim($_POST['product_name'] ?? ''),
            'category'            => trim($_POST['category'] ?? 'General'),
            'buying_price'        => (float) ($_POST['buying_price'] ?? 0),
            'selling_price'       => (float) ($_POST['selling_price'] ?? 0),
            'quantity'            => (int) ($_POST['quantity'] ?? 0),
            'low_stock_threshold' => (int) ($_POST['low_stock_threshold'] ?? LOW_STOCK_THRESHOLD),
            'expiry_date'         => trim($_POST['expiry_date'] ?? ''),
        ];

        if ($data['product_name'] === '') {
            flash('error', 'Product name is required.');
            $this->storeOld($data);
            $this->redirect($_SERVER['HTTP_REFERER'] ?? 'products');
        }

        return $data;
    }
}
