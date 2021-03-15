<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use HasFactory;

    public function rows()
    {
        return $this->HasMany(Row::class);
    }

    public function roteiro()
    {
        return $this->belongsTo(Roteiro::class);
    }
}
