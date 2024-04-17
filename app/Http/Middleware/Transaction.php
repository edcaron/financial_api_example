<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Transaction
{
    public function handle(Request $request, Closure $next)
    {
        DB::beginTransaction();

        $response = $next($request);

        if ($response->isSuccessful()) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $response;
    }
}
