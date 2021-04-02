<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradore extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'email',
        'nome',
        'apelido',
        'niveis_id',
    ];

    public function Niveis()
    {
        return $this->belongsTo('App\Models\Nivei');
    }

    public function unidades()
    {
        return $this->belongsToMany(Unidades::class,'colab_unidades');
    }

    public function intervencoesindividuais()
    {
        return $this->hasMany('App\Models\intervencoesindividuai');
    }

    public function intervencoesgrupo()
    {
        return $this->hasMany('App\Models\intervencoesgrupo');
    }

    public function grupos()
    {
        return $this->hasMany('App\Models\intervencoesgrupo');
    }
}
