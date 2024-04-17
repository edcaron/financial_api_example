<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\TransacaoRepositoryInterface;
use App\Models\Transacao;
use Illuminate\Database\Eloquent\Model;

class TransacaoRepository implements TransacaoRepositoryInterface
{
    public function find(int|string $key):? Model
    {
        throw new \Exception('not implemented');

        // return Transacao::find($key);
    }

    public function create(array $data): Model
    {
        return Transacao::create($data);
    }

    public function update(int|string $key, array $data): Model
    {
        throw new \Exception('not implemented');

        // $Transacao = $this->find($key);
        // if (!$Transacao) {
        //     return $this->create($data);
        // }

        // $Transacao->update($data);

        // return $Transacao;
    }
}
