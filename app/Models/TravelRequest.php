<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'nome_solicitante', // Adicione esse campo
        'destino',
        'data_ida',
        'data_volta',
        'status',
        'user_id', // Referência ao usuário
    ];
}
