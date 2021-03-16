<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoes_enfermeira extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'id',
        'alimentacao',
        'sono',
        'higiene',
        'notas',
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
