<?php

namespace App\Http\Controllers;

use App\Exceptions\ObjectNotFoundException;
use App\Http\Interfaces\Services\ContaServiceInterface;
use App\Http\Requests\ShowContaRequest;
use App\Http\Requests\StoreContaRequest;
use App\Http\Resources\ContaResource;

class ContaController extends Controller
{
    protected ContaServiceInterface $service;

    public function __construct(ContaServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(StoreContaRequest $request)
    {
        $data = $request->all();

        $conta = $this->service->store($data);

        return new ContaResource($conta);
    }

    public function show(ShowContaRequest $request)
    {
        $data = $request->all();

        $conta = $this->service->find($data['id']);

        if (!$conta) {
            throw new ObjectNotFoundException("conta não encontrada");
        }

        return new ContaResource($conta);
    }
}
