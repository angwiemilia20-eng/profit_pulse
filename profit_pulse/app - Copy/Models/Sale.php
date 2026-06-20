<?php

namespace App\Models;

use App\Core\Model;

class Sale extends Model
{
    public function all(): array
    {
        $sql = 'SELECT s.*, p.product_name, c.customer_name
                FROM sales s
                JOIN products p ON s.product_id = p.product_id
                LEFT JOIN customers c ON s.customer_id = c.customer_id
                ORDER BY s.sale_date DESC, s.sale_id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): int|false
    {
        $sql = 'INSERT INTO sales (product_id, customer_id, quantity, quantity_sold, unit_price, selling_price, total_amount, payment_type, sale_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $qty = $data['quantity'];
        $price = $data['unit_price'];
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            $data['product_id'],
            $data['customer_id'] ?: null,
            $qty,
            $qty,
            $price,
            $price,
            $data['total_amount'],
            $data['payment_type'] ?? 'cash',
            $data['sale_date'],
        ]);
        return $ok ? (int) $this->db->lastInsertId() : false;
    }

    public function totalSales(): float
    {
        return (float) $this->db->query('SELECT COALESCE(SUM(total_amount), 0) FROM sales')->fetchColumn();
    }

    public function costOfGoodsSold(): float
    {
        $sql = 'SELECT COALESCE(SUM(COALESCE(s.quantity, s.quantity_sold) * p.buying_price), 0)
                FROM sales s
                JOIN products p ON s.product_id = p.product_id';
        return (float) $this->db->query($sql)->fetchColumn();
    }

    public function dailyReport(?string $date = null): array
    {
        $date = $date ?? date('Y-m-d');
        $stmt = $this->db->prepare(
            'SELECT s.*, p.product_name FROM sales s
             JOIN products p ON s.product_id = p.product_id
             WHERE DATE(s.sale_date) = ? ORDER BY s.sale_id DESC'
        );
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    public function monthlyReport(int $year, int $month): array
    {
        $stmt = $this->db->prepare(
            'SELECT s.*, p.product_name FROM sales s
             JOIN products p ON s.product_id = p.product_id
             WHERE YEAR(s.sale_date) = ? AND MONTH(s.sale_date) = ?
             ORDER BY s.sale_date DESC'
        );
        $stmt->execute([$year, $month]);
        return $stmt->fetchAll();
    }

    public function monthlyTotal(int $year, int $month): float
    {
        $stmt = $this->db->prepare(
            'SELECT COALESCE(SUM(total_amount), 0) FROM sales
             WHERE YEAR(sale_date) = ? AND MONTH(sale_date) = ?'
        );
        $stmt->execute([$year, $month]);
        return (float) $stmt->fetchColumn();
    }

    public function dailyTotal(?string $date = null): float
    {
        $date = $date ?? date('Y-m-d');
        $stmt = $this->db->prepare(
            'SELECT COALESCE(SUM(total_amount), 0) FROM sales WHERE DATE(sale_date) = ?'
        );
        $stmt->execute([$date]);
        return (float) $stmt->fetchColumn();
    }
}
