<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Aluno extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nif',
        'nome',
        'data_nascimento',
        'email',
        'cod_aluno',
        'curso_id',
        'password',
    ];

    protected $rules = [
        'password' => 'required',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avaliacao(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }
}
