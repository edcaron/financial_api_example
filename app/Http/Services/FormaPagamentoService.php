<?php

namespace App\Http\Services;

use App\Exceptions\ObjectNotFoundException;
use App\Http\Interfaces\Services\FormaPagamentoServiceInterface;
use Exception;

class FormaPagamentoService implements FormaPagamentoServiceInterface
{
    const PIX     = 'P';
    const CREDITO = 'C';
    const DEBITO  = 'D';

    public function getFormas(): array
    {
        return [
            self::CREDITO,
            self::DEBITO,
            self::PIX,
        ];
    }

    public function getTaxaByForma(string $forma): float
    {
        return match ($forma) {
            self::CREDITO => 4,
            self::DEBITO => 3,
            self::PIX => 0,
            default =>  throw new ObjectNotFoundException("forma de pagamento '{$forma}' desconhecido"),
        };
    }

    public function getValorTaxaByForma(string $forma, float $valor): float
    {
        $taxa_taxa = $this->getTaxaByForma($forma);

        return $valor * $taxa_taxa / 100;
    }
}
