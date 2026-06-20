<?php

namespace App\Models;

use App\Core\Model;

class Expense extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM expenses ORDER BY expense_date DESC')->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO expenses (expense_type, amount, description, expense_date) VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['expense_type'],
            $data['amount'],
            $data['description'] ?? '',
            $data['expense_date'],
        ]);
    }

    public function total(): float
    {
        return (float) $this->db->query('SELECT COALESCE(SUM(amount), 0) FROM expenses')->fetchColumn();
    }

    public function monthlyTotal(int $year, int $month): float
    {
        $stmt = $this->db->prepare(
            'SELECT COALESCE(SUM(amount), 0) FROM expenses
             WHERE YEAR(expense_date) = ? AND MONTH(expense_date) = ?'
        );
        $stmt->execute([$year, $month]);
        return (float) $stmt->fetchColumn();
    }
}
