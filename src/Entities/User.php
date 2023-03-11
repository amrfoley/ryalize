<?php

namespace App\Entities;

final class User extends Entity
{
    /**
     * @return array
     */
    public static function sql(): array
    {
        return [
            'index' => 'SELECT * FROM users',
            'show' => 'SELECT * FROM users WHERE id = :id',
            'store' => 'INSERT INTO users (name, email, phone) VALUES (:name, :email, :phone)',
            'update' => 'UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id',
            'destroy' => 'DELETE FROM users WHERE id = :id'
        ];
    }
}
