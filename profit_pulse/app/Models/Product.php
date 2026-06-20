<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM products ORDER BY product_name ASC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE product_id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO products (product_name, category, buying_price, selling_price, quantity, low_stock_threshold, expiry_date)
                VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['product_name'],
            $data['category'] ?? 'General',
            $data['buying_price'],
            $data['selling_price'],
            $data['quantity'],
            $data['low_stock_threshold'] ?? LOW_STOCK_THRESHOLD,
            $data['expiry_date'] ?: null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE products SET product_name = ?, category = ?, buying_price = ?, selling_price = ?,
                quantity = ?, low_stock_threshold = ?, expiry_date = ? WHERE product_id = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['product_name'],
            $data['category'] ?? 'General',
            $data['buying_price'],
            $data['selling_price'],
            $data['quantity'],
            $data['low_stock_threshold'] ?? LOW_STOCK_THRESHOLD,
            $data['expiry_date'] ?: null,
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE product_id = ?');
        return $stmt->execute([$id]);
    }

    public function reduceStock(int $id, int $qty): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE products SET quantity = quantity - ? WHERE product_id = ? AND quantity >= ?'
        );
        $stmt->execute([$qty, $id, $qty]);
        return $stmt->rowCount() > 0;
    }

    public function lowStock(): array
    {
        $sql = 'SELECT * FROM products WHERE quantity <= low_stock_threshold ORDER BY quantity ASC';
        return $this->db->query($sql)->fetchAll();
    }

    public function expiringSoon(int $days = EXPIRY_ALERT_DAYS): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM products
             WHERE expiry_date IS NOT NULL
               AND expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
             ORDER BY expiry_date ASC'
        );
        $stmt->execute([$days]);
        return $stmt->fetchAll();
    }

    public function expired(): array
    {
        $sql = 'SELECT * FROM products
                WHERE expiry_date IS NOT NULL AND expiry_date < CURDATE()
                ORDER BY expiry_date ASC';
        return $this->db->query($sql)->fetchAll();
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }

    public function inStock(): array
    {
        return $this->db->query('SELECT * FROM products WHERE quantity > 0 ORDER BY product_name ASC')->fetchAll();
    }
}
