<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    protected $fillable = [
        'conteudo',
    ];

    public function roteiro()
    {
        return $this->belongsTo(Roteiro::class);
    }
}
