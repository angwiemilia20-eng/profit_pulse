<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Debt;

class DebtController extends Controller
{
    private Debt $debts;

    public function __construct()
    {
        $this->debts = new Debt();
    }

    public function index(): void
    {
        $this->requireAuth();
        $this->view('debts/index', [
            'pageTitle'        => 'Customer Debts',
            'debts'            => $this->debts->all(),
            'totalOutstanding' => $this->debts->totalOutstanding(),
        ]);
    }

    public function show(): void
    {
        $this->requireAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $debt = $this->debts->find($id);

        if (!$debt) {
            flash('error', 'Debt record not found.');
            $this->redirect('debts');
        }

        $this->view('debts/show', [
            'pageTitle' => 'Debt Details',
            'debt'      => $debt,
            'payments'  => $this->debts->payments($id),
        ]);
    }

    public function pay(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $debtId = (int) ($_POST['debt_id'] ?? 0);
        $amount = (float) ($_POST['amount'] ?? 0);
        $date = $_POST['payment_date'] ?? date('Y-m-d');
        $notes = trim($_POST['notes'] ?? '');

        if ($amount <= 0) {
            flash('error', 'Enter a valid payment amount.');
            $this->redirect('debts/show?id=' . $debtId);
        }

        if ($this->debts->recordPayment($debtId, $amount, $date, $notes)) {
            flash('success', 'Payment recorded successfully.');
        } else {
            flash('error', 'Payment failed. Check the amount and try again.');
        }
        $this->redirect('debts/show?id=' . $debtId);
    }
}
