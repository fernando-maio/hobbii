<?php

namespace App\Contracts\Services;

interface ActionServiceInterface
{
    public function list();

    public function run(int $id);
    
    public function stop(int $id);

    public function invoice(int $id);
}