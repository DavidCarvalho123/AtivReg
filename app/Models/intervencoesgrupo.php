<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoesgrupo extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'data_realizada','hora_iniciada','hora_terminada','info_id','grupo_id'
    ];

    public function grupos()
    {
        return $this->belongsTo('App\Models\Grupo');
    }

    public function Clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_intervencoesgrupos');
    }

    public function intervencoesindividuais()
    {
        return $this->hasMany('App\Models\intervencoesindividuai');
    }

    public function fotos()
    {
        return $this->hasMany('App\Models\fotos');
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Colaboradore::class, 'colab_intervencoesgrupos');
    }

    public function infoable()
    {
        return $this->morphTo();
    }

}
