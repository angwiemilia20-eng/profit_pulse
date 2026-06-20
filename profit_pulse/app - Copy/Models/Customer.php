<?php

namespace App\Models;

use App\Core\Model;

class Customer extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM customers ORDER BY customer_name ASC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM customers WHERE customer_id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int|false
    {
        $stmt = $this->db->prepare(
            'INSERT INTO customers (customer_name, phone, address) VALUES (?, ?, ?)'
        );
        $ok = $stmt->execute([
            $data['customer_name'],
            $data['phone'] ?? '',
            $data['address'] ?? '',
        ]);
        return $ok ? (int) $this->db->lastInsertId() : false;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE customers SET customer_name = ?, phone = ?, address = ? WHERE customer_id = ?'
        );
        return $stmt->execute([
            $data['customer_name'],
            $data['phone'] ?? '',
            $data['address'] ?? '',
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM customers WHERE customer_id = ?');
        return $stmt->execute([$id]);
    }
}
