<?php

namespace App\Http\Services;

use App\Exceptions\DuplicateObjectException;
use App\Exceptions\SemSaldoException;
use App\Http\Interfaces\Repositories\ContaRepositoryInterface;
use App\Http\Interfaces\Services\ContaServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ContaService implements ContaServiceInterface
{
    protected ContaRepositoryInterface $contaRepository;
    protected ContaServiceInterface $contaService;

    public function __construct(ContaRepositoryInterface $contaRepository)
    {
        $this->contaRepository = $contaRepository;
    }

    public function find(int|string $key):? Model
    {
        return $this->contaRepository->find($key);
    }

    public function store(array $data): Model
    {
        $conta = $this->contaRepository->find($data['conta_id']);

        if ($conta) {
            throw new DuplicateObjectException("conta '{$data['conta_id']}' já existente");
        }

        $conta = $this->contaRepository->create(
            [
                'id' => $data['conta_id'],
                'saldo' => $data['valor'],
            ]
        );

        $conta->save();

        return $conta;
    }

    public function atualizaSaldo(Model $transacao): Model
    {
        if ($transacao->valor_total > $transacao->conta->saldo) {
            throw new SemSaldoException("Não há saldo suficiente para realizar a transacao de {$transacao->valor_total}");
        }

        $conta = $this->contaRepository->update($transacao->conta->id, ['saldo' => $transacao->conta->saldo - $transacao->valor_total]);

        $transacao->conta()->associate($conta);

        return $conta;
    }
}
