<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Expense;

class ExpenseController extends Controller
{
    private Expense $expenses;

    public function __construct()
    {
        $this->expenses = new Expense();
    }

    public function index(): void
    {
        $this->requireAuth();
        $this->view('expenses/index', [
            'pageTitle' => 'Expenses',
            'expenses'  => $this->expenses->all(),
            'total'     => $this->expenses->total(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->view('expenses/create', ['pageTitle' => 'Add Expense']);
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $data = [
            'expense_type' => trim($_POST['expense_type'] ?? ''),
            'amount'       => (float) ($_POST['amount'] ?? 0),
            'description'  => trim($_POST['description'] ?? ''),
            'expense_date' => $_POST['expense_date'] ?? date('Y-m-d'),
        ];

        if ($data['expense_type'] === '' || $data['amount'] <= 0) {
            flash('error', 'Expense type and a valid amount are required.');
            $this->storeOld($data);
            $this->redirect('expenses/create');
        }

        if ($this->expenses->create($data)) {
            flash('success', 'Expense recorded successfully.');
        } else {
            flash('error', 'Failed to record expense.');
        }
        $this->redirect('expenses');
    }
}
