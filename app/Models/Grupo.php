<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'notas',
    ];

    public function Clientes()
    {
        return $this->belongsToMany(Cliente::class, 'grupos_clientes');
    }
    public function intervencoesgrupo()
    {
        return $this->hasMany('App\Models\intervencoesgrupo');
    }
}
