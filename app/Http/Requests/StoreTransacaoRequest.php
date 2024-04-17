<?php

namespace App\Http\Requests;

use App\Http\Interfaces\Services\FormaPagamentoServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransacaoRequest extends FormRequest
{
    protected FormaPagamentoServiceInterface $formaPagamentoService;

    public function __construct(
        FormaPagamentoServiceInterface $formaPagamentoService
    )
    {
        $this->formaPagamentoService = $formaPagamentoService;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $optionsFormas = $this->formaPagamentoService->getFormas();

        return [
            'conta_id' => ['required', 'integer'],
            'forma_pagamento' => ['required', 'string', Rule::in($optionsFormas)],
            'valor' => ['required', 'decimal:0,2']
        ];
    }
}
