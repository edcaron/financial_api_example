<?php

namespace App\Http\Controllers;

use App\Exceptions\ObjectNotFoundException;
use App\Http\Interfaces\Services\TransacaoServiceInterface;
use App\Http\Requests\StoreTransacaoRequest;
use App\Http\Resources\ContaResource;
use Illuminate\Http\Response;

class TransacaoController extends Controller
{
    protected TransacaoServiceInterface $service;

    public function __construct(TransacaoServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransacaoRequest $request)
    {
        $data = $request->all();

        $transacao = $this->service->store($data);

        return response(new ContaResource($transacao->conta), Response::HTTP_CREATED);
    }
}
