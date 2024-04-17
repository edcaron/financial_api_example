<?php

namespace Tests\Feature;

use App\Exceptions\DuplicateObjectException;
use App\Exceptions\ObjectNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContaTest extends TestCase
{
    use RefreshDatabase;

    public function testGetContaInexistente404(): void
    {
        $response = $this->get('/api/conta?id=1');

        $response->assertStatus(404);
    }

    public function testGetContaExistente(): void
    {
        $this->seed('TestSeeder');

        $conta_data = [
            "conta_id" => 1234,
            "valor" => 189.70
        ];

        $response = $this->get("/api/conta?id={$conta_data['conta_id']}");

        $response->assertStatus(200);

        $expected = [
            "conta_id" => $conta_data["conta_id"],
            "saldo" => $conta_data["valor"]
        ];

        $response->assertJson($expected);

        $this->assertDatabaseHas('contas', [
            "id" => $conta_data["conta_id"],
            "saldo" => $conta_data["valor"]
        ]);
    }

    public function testCriarContaNova(): void
    {
        $conta_data = [
            "conta_id" => 1234,
            "valor" => 189.70
        ];

        $response = $this->post("/api/conta", $conta_data);

        $expected = [
            "conta_id" => $conta_data["conta_id"],
            "saldo" => $conta_data["valor"]
        ];

        $response->assertStatus(201);

        $response->assertJson($expected);
    }

    public function testCriarContaDuplicadaError(): void
    {
        $this->seed('TestSeeder');

        $conta_data = [
            "conta_id" => 1234,
            "valor" => 1
        ];

        $this->assertThrows(
            fn () => $this->withoutExceptionHandling()->withoutDeprecationHandling()->post("/api/conta", $conta_data),
            DuplicateObjectException::class
        );
    }
}
