<?php

namespace App\Http\Services;

use App\Exceptions\ObjectNotFoundException;
use App\Http\Interfaces\Repositories\ContaRepositoryInterface;
use App\Http\Interfaces\Repositories\TransacaoRepositoryInterface;
use App\Http\Interfaces\Services\ContaServiceInterface;
use App\Http\Interfaces\Services\FormaPagamentoServiceInterface;
use App\Http\Interfaces\Services\TransacaoServiceInterface;
use Illuminate\Database\Eloquent\Model;

class TransacaoService implements TransacaoServiceInterface
{
    protected FormaPagamentoServiceInterface $formaPagamentoService;
    protected ContaServiceInterface $contaService;
    protected ContaRepositoryInterface $contaRepository;
    protected TransacaoRepositoryInterface $transacaoRepository;

    public function __construct(
        FormaPagamentoServiceInterface $formaPagamentoService,
        ContaServiceInterface $contaService,
        ContaRepositoryInterface $contaRepository,
        TransacaoRepositoryInterface $transacaoRepository
    )
    {
        $this->formaPagamentoService = $formaPagamentoService;
        $this->contaService = $contaService;
        $this->contaRepository = $contaRepository;
        $this->transacaoRepository = $transacaoRepository;
    }

    public function store(array $data): Model
    {
        $conta = $this->contaRepository->find($data['conta_id']);

        if (!$conta) {
            throw new ObjectNotFoundException("conta '{$data['conta_id']}' inexistente", 400);
        }

        $valor_taxa = $this->formaPagamentoService->getValorTaxaByForma($data['forma_pagamento'], $data['valor']);

        $valor_total = $data['valor'] + $valor_taxa;

        $transacao = $this->transacaoRepository->create(
            [
                'conta_id'        => $data['conta_id']        ,
                'valor_original'  => $data['valor']           ,
                'valor_total'     => $valor_total             ,
                'valor_taxa'      => $valor_taxa              ,
                'forma_pagamento' => $data['forma_pagamento'] ,
            ]
        );

        $conta = $this->contaService->atualizaSaldo($transacao);

        return $transacao;
    }
}
