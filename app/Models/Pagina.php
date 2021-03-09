<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    protected $fillable = [
        'conteudo',
        'plano',
        'angulo',
        'lado',
        'anotacoes',
        'is_flashback',
        'is_subjetivo',
        'is_impacto',
        'is_off',
    ];

    public function roteiro()
    {
        return $this->belongsTo(Roteiro::class);
    }

    public function falas()
    {
        return $this->HasMany(Fala::class);
    }
}
