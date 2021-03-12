<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoesindividuai extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'data_realizada', 'hora_iniciada', 'hora_terminada', 'info_id', 'cliente_id','grupo_id'
    ];

    protected $guarded = [];

    public function fotos()
    {
        return $this->belongsToMany(fotos::class, 'fotos_intervencoesindividuais');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    public function intervencoesgrupo()
    {
        return $this->belongsTo('App\Models\intervencoesgrupo');
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Colaboradore::class, 'colab_intervencoesindividuais');
    }


    public function infoable()
    {
        return $this->morphTo();
    }

}
