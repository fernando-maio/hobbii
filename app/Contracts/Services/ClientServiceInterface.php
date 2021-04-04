<?php

namespace App\Contracts\Services;

interface ClientServiceInterface
{
    public function list();

    public function store(array $data);
    
    public function getById(int $id);
    
    public function update(int $id, array $data);
    
    public function delete(int $id);
}