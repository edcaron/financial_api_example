<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\ContaRepositoryInterface;
use App\Models\Conta;
use Illuminate\Database\Eloquent\Model;

class ContaRepository implements ContaRepositoryInterface
{
    public function find(int|string $key):? Model
    {
        return Conta::find($key);
    }

    public function create(array $data): Model
    {
        return Conta::create($data);
    }

    public function update(int|string $key, array $data): Model
    {
        $conta = $this->find($key);
        if (!$conta) {
            return $this->create($data);
        }

        $conta->update($data);

        return $conta;
    }
}
