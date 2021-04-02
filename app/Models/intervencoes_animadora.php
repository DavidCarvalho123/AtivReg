<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoes_animadora extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'id',
        'atividades'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    
    public function intervencoesgrupo()
    {
        return $this->morphOne(intervencoesgrupo::class,'infoable');
    }

    public function intervencoesindividuais()
    {
        return $this->morphOne(intervencoesindividuai::class,'infoable');
    }

    public function Niveis()
    {
        return $this->morphToMany(Nivei::class, 'tableable');
    }
}
