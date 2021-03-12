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
        return $this->belongsToMany(intervencoesindividuai::class, 'colab_intervencoesindividuais');
    }

    public function intervencoesgrupo()
    {
        return $this->belongsToMany(intervencoesgrupo::class, 'colab_intervencoesgrupos');
    }
}
