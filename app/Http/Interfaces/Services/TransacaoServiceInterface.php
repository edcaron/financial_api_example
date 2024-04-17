<?php

namespace App\Http\Interfaces\Services;

use Illuminate\Database\Eloquent\Model;

interface TransacaoServiceInterface
{
    public function store(array $data): Model;
}
