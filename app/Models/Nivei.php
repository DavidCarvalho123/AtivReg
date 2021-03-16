<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivei extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'nivel'
    ];

    public function colaboradores()
    {
        return $this->hasMany('App\Models\Colaboradore');
    }

    public function intervencoes_animadora()
    {
        return $this->morphedByMany(intervencoes_animadora::class, 'tableable');
    }
    public function intervencoes_enfermeira()
    {
        return $this->morphedByMany(intervencoes_enfermeira::class, 'tableable');
    }
    public function intervencoes_gestorcliente()
    {
        return $this->morphedByMany(intervencoes_gestorclientes::class, 'tableable');
    }
    public function intervencoes_psicologo()
    {
        return $this->morphedByMany(intervencoes_psicologo::class, 'tableable');
    }
}
