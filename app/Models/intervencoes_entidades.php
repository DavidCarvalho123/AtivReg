<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoes_entidades extends Model
{
    use HasFactory;
    protected $table = "intervencoesentidades";
    protected $connection = "mysql2";
    protected $fillable=[
        'intervencao_grupo_id', 'intervencao_individuai_id'
    ];

    public function intervencao_grupo()
    {
        return $this->belongsTo('App\Models\intervencoesgrupo');
    }
    public function intervencao_individual()
    {
        return $this->belongsTo('App\Models\intervencoesindividuai');
    }
}
