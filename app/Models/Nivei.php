<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivei extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'nivel',
    ];

    public function colaboradores()
    {
        return $this->hasMany('App\Models\Colaboradore');
    }

    public function niveis_intervencoes()
    {
        return $this->hasMany('App\Models\niveis_intervencoes');
    }


}
