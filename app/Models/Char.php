<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'roteiro_id',
    ];

    public function roteiro()
    {
        return $this->BelongsTo(Roteiro::Class);
    }

    public function falas()
    {
        return $this->HasMany(Fala::Class);
    }
}
