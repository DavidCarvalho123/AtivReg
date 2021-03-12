<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fotos extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'nome_foto', 'link', 'intervencao_grupo_id',
    ];

    public function intervencao_grupo()
    {
        return $this->belongsTo('App\Models\intervencoesgrupo');
    }

    public function intervencao_individual()
    {
        return $this->belongsToMany(intervencao_individual::class, 'fotos_intervencoesindividuais');
    }
}
