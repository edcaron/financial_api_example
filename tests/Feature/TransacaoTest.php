<?php

namespace Tests\Feature;

use App\Exceptions\ObjectNotFoundException;
use App\Exceptions\SemSaldoException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransacaoTest extends TestCase
{
    use RefreshDatabase;

    public function testCriarTransacaoPersisteRetorno(): void
    {
        $this->seed('TestSeeder');

        $saldo_inicial_conta = 189.70;

        $transacao_data = [
            "forma_pagamento" => "P",
            "conta_id" => 1234,
            "valor" => 10
        ];

        $response = $this->post("/api/transacao", $transacao_data);

        $expected = [
            "conta_id" => $transacao_data["conta_id"],
            "saldo" => $saldo_inicial_conta - $transacao_data["valor"]
        ];

        $response->assertStatus(201);

        $response->assertJson($expected);

        $this->assertDatabaseHas('contas', [
            "id" => $expected["conta_id"],
            "saldo" => $expected["saldo"]
        ]);

        $this->assertDatabaseHas('transacaos', [
            "forma_pagamento" => $transacao_data["forma_pagamento"],
            "conta_id" => $transacao_data["conta_id"],
            "valor_total" => $transacao_data["valor"]
        ]);
    }

    public function testCriarTransacaoContaInexistenteError(): void
    {
        $transacao_data = [
            "forma_pagamento" => "P",
            "conta_id" => 100,
            "valor" => 10
        ];

        $response = $this->post("/api/transacao", $transacao_data);

        $response->assertStatus(404);
    }

    public function testCriarTransacaoFormaInexistenteError(): void
    {
        $transacao_data = [
            "forma_pagamento" => "X",
            "conta_id" => 100,
            "valor" => 10
        ];

        $response = $this->post("/api/transacao", $transacao_data);

        $response->assertInvalid(['forma_pagamento']);
    }

    public function testCriarTransacaoMaiorSaldo(): void
    {
        $this->seed('TestSeeder');

        $transacao_data = [
            "forma_pagamento" => "P",
            "conta_id" => 1234,
            "valor" => 100000
        ];

        $response = $this->post("/api/transacao", $transacao_data);

        $response->assertStatus(404);

        $this->assertThrows(
            fn () => $this->withoutExceptionHandling()->withoutDeprecationHandling()->post("/api/transacao", $transacao_data),
            SemSaldoException::class
        );
    }
}
