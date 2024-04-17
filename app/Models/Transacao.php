<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'conta_id',
        'valor_original',
        'valor_total',
        'valor_taxa',
        'forma_pagamento'
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'conta_id');
    }
}
