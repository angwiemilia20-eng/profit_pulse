<?php

namespace App\Models;

use App\Core\Model;

class Debt extends Model
{
    public function all(): array
    {
        $sql = 'SELECT d.*, c.customer_name, c.phone
                FROM debts d
                JOIN customers c ON d.customer_id = c.customer_id
                ORDER BY d.balance DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, c.customer_name, c.phone, c.address
             FROM debts d
             JOIN customers c ON d.customer_id = c.customer_id
             WHERE d.debt_id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int|false
    {
        $stmt = $this->db->prepare(
            'INSERT INTO debts (customer_id, sale_id, amount_owed, amount_paid, balance, date_created)
             VALUES (?, ?, ?, 0, ?, ?)'
        );
        $ok = $stmt->execute([
            $data['customer_id'],
            $data['sale_id'] ?? null,
            $data['amount_owed'],
            $data['amount_owed'],
            $data['date_created'],
        ]);
        return $ok ? (int) $this->db->lastInsertId() : false;
    }

    public function recordPayment(int $debtId, float $amount, string $date, string $notes = ''): bool
    {
        $this->db->beginTransaction();
        try {
            $debt = $this->find($debtId);
            if (!$debt || $amount <= 0 || $amount > $debt['balance']) {
                $this->db->rollBack();
                return false;
            }

            $stmt = $this->db->prepare(
                'INSERT INTO debt_payments (debt_id, amount, payment_date, notes) VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([$debtId, $amount, $date, $notes]);

            $newPaid = $debt['amount_paid'] + $amount;
            $newBalance = $debt['amount_owed'] - $newPaid;

            $stmt = $this->db->prepare(
                'UPDATE debts SET amount_paid = ?, balance = ? WHERE debt_id = ?'
            );
            $stmt->execute([$newPaid, $newBalance, $debtId]);

            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function payments(int $debtId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM debt_payments WHERE debt_id = ? ORDER BY payment_date DESC'
        );
        $stmt->execute([$debtId]);
        return $stmt->fetchAll();
    }

    public function totalOutstanding(): float
    {
        return (float) $this->db->query('SELECT COALESCE(SUM(balance), 0) FROM debts WHERE balance > 0')->fetchColumn();
    }

    public function byCustomer(int $customerId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM debts WHERE customer_id = ? ORDER BY date_created DESC'
        );
        $stmt->execute([$customerId]);
        return $stmt->fetchAll();
    }
}
