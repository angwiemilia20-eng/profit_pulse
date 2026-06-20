<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1'
        );
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $username, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(
            'INSERT INTO users (username, full_name, email, password) VALUES (?, ?, ?, ?)'
        );
        $email = $username . '@local.profitpulse';
        return $stmt->execute([$username, $username, $email, $hash]);
    }

    public function verify(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);
        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        // Legacy plain-text passwords from early prototype
        if ($user['password'] === $password) {
            $this->upgradePassword((int) $user['user_id'], $password);
            return $user;
        }

        return null;
    }

    private function upgradePassword(int $userId, string $password): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE user_id = ?');
        $stmt->execute([$hash, $userId]);
    }
}
