<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiare extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'nome',
        'apelido',
        'nome_utilizador',
        'password',
        'nr_telefone',
    ];

    protected $hidden =[
        'password',
    ];

    public function Clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_familiares');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
