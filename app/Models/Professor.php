<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professor extends Model
{
    // Especifique o nome da tabela
    protected $table = 'professores';
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function avaliacao(): BelongsTo
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function UC(): HasMany
    {
        return $this->hasMany(UnidadeCurricular::class);
    }
}
