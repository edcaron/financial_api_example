<?php

namespace App\Providers;

use App\Http\Interfaces\Repositories\ContaRepositoryInterface;
use App\Http\Interfaces\Repositories\TransacaoRepositoryInterface;
use App\Http\Interfaces\Services\ContaServiceInterface;
use App\Http\Interfaces\Services\FormaPagamentoServiceInterface;
use App\Http\Interfaces\Services\TransacaoServiceInterface;
use App\Http\Repositories\ContaRepository;
use App\Http\Repositories\TransacaoRepository;
use App\Http\Services\ContaService;
use App\Http\Services\FormaPagamentoService;
use App\Http\Services\TransacaoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContaServiceInterface::class, ContaService::class);
        $this->app->bind(TransacaoServiceInterface::class, TransacaoService::class);
        $this->app->bind(FormaPagamentoServiceInterface::class, FormaPagamentoService::class);


        $this->app->bind(ContaRepositoryInterface::class, ContaRepository::class);
        $this->app->bind(TransacaoRepositoryInterface::class, TransacaoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
