<?php

namespace App\Entities;

final class Location extends Entity
{
    /**
     * @return array
     */
    public static function sql(): array
    {
        return [
            'index' => 'SELECT * FROM locations',
            'show' => 'SELECT * FROM locations WHERE id = :id',
            'store' => 'INSERT INTO locations (country, state, city) VALUES (:country, :state, :city)',
            'update' => 'UPDATE locations SET country = :country, state = :state, city = :city WHERE id = :id',
            'destroy' => 'DELETE FROM locations WHERE id = :id'
        ];
    }
}
