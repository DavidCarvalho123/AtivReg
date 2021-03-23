<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $connection = "mysql2";
    protected $fillable=[
        'nome',
        'apelido',
        'data_entrou',
        'notas',
        'foto',
        'unidades_id',
    ];



    public function familiares()
    {
        return $this->belongsToMany(Familiare::class, 'clientes_familiares');
    }

    public function unidades()
    {
        return $this->belongsTo('App\Models\Unidades');
    }

    public function grupo()
    {
        return $this->belongsToMany(Grupo::class, 'grupos_clientes');
    }

    public function intervencoesgrupo()
    {
        return $this->belongsToMany(intervencoesgrupo::class, 'clientes_intervencoesgrupos');
    }

    public function intervencoesindividuai()
    {
        return $this->hasMany('App\Models\intervencoesindividuai');
    }
}
