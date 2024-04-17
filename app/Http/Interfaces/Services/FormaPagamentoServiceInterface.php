<?php

namespace App\Http\Interfaces\Services;

interface FormaPagamentoServiceInterface
{
    public function getFormas(): array;

    public function getTaxaByForma(string $forma): float;

    public function getValorTaxaByForma(string $forma, float $valor): float;
}
