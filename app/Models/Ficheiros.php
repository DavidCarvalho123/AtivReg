<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficheiros extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'link', 'nome_ficheiro', 'descricao_ficheiro',
    ];

    public function pagina_principal()
    {
        return $this->belongsToMany(Pagina_Principal::class, 'ficheiros_paginaprincipals');
    }
}
