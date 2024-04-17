<?php

namespace App\Http\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;

interface AppRepositoryInterface
{
    public function find(int|string $key):? Model;

    public function create(array $data): Model;

    public function update(int|string $key, array $data): Model;
}
