<?php

namespace Tests\Unit;

use App\Exceptions\ObjectNotFoundException;
use App\Http\Services\FormaPagamentoService;
use PHPUnit\Framework\TestCase;

class FormaPagamentoServiceTest extends TestCase
{
    public function testGetFormasCountIs3(): void
    {
        $service = new FormaPagamentoService;

        $actual = $service->getFormas();

        $expected = 3;

        $this->assertEquals($expected, count($actual));
    }

    public function testGetTaxaByFormaInexistenteException(): void
    {
        $service = new FormaPagamentoService;

        $this->expectException(ObjectNotFoundException::class);

        $service->getTaxaByForma('X');
    }

    public function testGetTaxaByTodasFormasExiste(): void
    {
        $service = new FormaPagamentoService;

        $formas = $service->getFormas();

        foreach ($formas as $forma) {
            $taxa = $service->getTaxaByForma($forma);

            $this->assertIsNumeric($taxa);
        }
    }

    public function testGetValorTaxaByFormaCreditoCalculoIs4(): void
    {
        $service = new FormaPagamentoService;

        $valor_teste = 50;
        $expected = 2;

        $actual = $service->getValorTaxaByForma(FormaPagamentoService::CREDITO, $valor_teste);

        $this->assertEquals($expected, $actual);
    }

    public function testGetValorTaxaByFormaDebitoCalculoIs3(): void
    {
        $service = new FormaPagamentoService;

        $valor_teste = 50;
        $expected = 1.5;

        $actual = $service->getValorTaxaByForma(FormaPagamentoService::DEBITO, $valor_teste);

        $this->assertEquals($expected, $actual);
    }

    public function testGetValorTaxaByFormaPixCalculoIs0(): void
    {
        $service = new FormaPagamentoService;

        $valor_teste = 50;
        $expected = 0;

        $actual = $service->getValorTaxaByForma(FormaPagamentoService::PIX, $valor_teste);

        $this->assertEquals($expected, $actual);
    }
}
