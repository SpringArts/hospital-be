<?php

namespace App\Interfaces\User;

interface UserLogInterface {
    public function fetchAll(int $limit , int $page);
    public function store(array $data);
}