<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina_Principal extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'unidades_id'
    ];

    public function unidades()
    {
        return $this->belongsTo('App\Models\Unidades');
    }

    public function ficheiros()
    {
        return $this->belongsToMany(Ficheiros::class, 'ficheiros_paginaprincipals');
    }
}
