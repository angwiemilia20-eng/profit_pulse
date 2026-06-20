<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Customer;
use App\Models\Debt;

class CustomerController extends Controller
{
    private Customer $customers;
    private Debt $debts;

    public function __construct()
    {
        $this->customers = new Customer();
        $this->debts = new Debt();
    }

    public function index(): void
    {
        $this->requireAuth();
        $this->view('customers/index', [
            'pageTitle' => 'Customers',
            'customers' => $this->customers->all(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->view('customers/create', ['pageTitle' => 'Add Customer']);
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $data = [
            'customer_name' => trim($_POST['customer_name'] ?? ''),
            'phone'         => trim($_POST['phone'] ?? ''),
            'address'       => trim($_POST['address'] ?? ''),
        ];

        if ($data['customer_name'] === '') {
            flash('error', 'Customer name is required.');
            $this->storeOld($data);
            $this->redirect('customers/create');
        }

        if ($this->customers->create($data)) {
            flash('success', 'Customer added successfully.');
        } else {
            flash('error', 'Failed to add customer.');
        }
        $this->redirect('customers');
    }

    public function show(): void
    {
        $this->requireAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $customer = $this->customers->find($id);

        if (!$customer) {
            flash('error', 'Customer not found.');
            $this->redirect('customers');
        }

        $this->view('customers/show', [
            'pageTitle' => $customer['customer_name'],
            'customer'  => $customer,
            'debts'     => $this->debts->byCustomer($id),
        ]);
    }

    public function edit(): void
    {
        $this->requireAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $customer = $this->customers->find($id);

        if (!$customer) {
            flash('error', 'Customer not found.');
            $this->redirect('customers');
        }

        $this->view('customers/edit', [
            'pageTitle' => 'Edit Customer',
            'customer'  => $customer,
        ]);
    }

    public function update(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $id = (int) ($_POST['customer_id'] ?? 0);
        $data = [
            'customer_name' => trim($_POST['customer_name'] ?? ''),
            'phone'         => trim($_POST['phone'] ?? ''),
            'address'       => trim($_POST['address'] ?? ''),
        ];

        if ($data['customer_name'] === '') {
            flash('error', 'Customer name is required.');
            $this->redirect('customers/edit?id=' . $id);
        }

        if ($this->customers->update($id, $data)) {
            flash('success', 'Customer updated.');
        } else {
            flash('error', 'Update failed.');
        }
        $this->redirect('customers');
    }

    public function delete(): void
    {
        $this->requireAuth();
        $this->validateCsrf();

        $id = (int) ($_POST['customer_id'] ?? 0);
        if ($this->customers->delete($id)) {
            flash('success', 'Customer deleted.');
        } else {
            flash('error', 'Could not delete customer.');
        }
        $this->redirect('customers');
    }
}
