<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roteiro extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'nome',
        'is_public',
        'is_marvelway',
        'user_id',
        'is_concluido',
    ];

    public function generos()
    {
        return $this->BelongstoMany(Genero::Class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paginas()
    {
        return $this->HasMany(Pagina::class);
    }





}
