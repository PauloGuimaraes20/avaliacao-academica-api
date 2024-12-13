<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Avaliacao extends Model
{
    // Especifique o nome da tabela
    protected $table = 'avaliacoes';

    use HasFactory;

    protected $fillable = [
        'data_avaliacao',
        'comentario',
        'nota',
        'aluno_id',
        'professor_id',
        'curso_id',
        'uc_id',

    ];

    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }

    public function curso(): HasOne
    {
        return $this->hasOne(Curso::class);
    }
    public function professor(): HasMany
    {
        return $this->hasMany(Professor::class);
    }
    public function uc(): HasMany
    {
        return $this->hasMany(UnidadeCurricular::class);
    }
}
