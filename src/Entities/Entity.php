<?php

namespace App\Entities;

abstract class Entity
{
    abstract public static function sql(): array;
}