<?php

namespace App\Http\Interfaces\Services;

use Illuminate\Database\Eloquent\Model;

interface ContaServiceInterface
{
    public function find(int|string $key):? Model;

    public function store(array $data): Model;

    public function atualizaSaldo(Model $transacao): Model;
}
