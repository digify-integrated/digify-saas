<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    protected string $table = 'users';

    /**
     * Create a new user
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (username, email, password, verification_token, token_expires_at, is_verified, created_at, updated_at) 
                VALUES (:username, :email, :password, :token, :expires, :is_verified, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'token' => $data['verification_token'],
            'expires' => $data['token_expires_at'],
            'is_verified' => $data['is_verified']
        ]);
    }

    /**
     * Find user by email or username
     */
    public function findByEmailOrUsername(string $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :value OR username = :value LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Find user by verification token
     */
    public function findByVerificationToken(string $token): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE verification_token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Mark user as verified
     */
    public function verifyUser(int $userId): bool
    {
        $sql = "UPDATE {$this->table} 
                SET is_verified = 1, verification_token = NULL, token_expires_at = NULL, updated_at = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId]);
    }
}
