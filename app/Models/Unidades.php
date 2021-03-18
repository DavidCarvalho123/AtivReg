<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    use HasFactory;

    protected $connection = "mysql2";

    protected $fillable=[
        'id', 'unidade','nr_telefone','email'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    public function pagina_principal()
    {
        return $this->hasOne('App\Models\Pagina_Principal');
    }

    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Colaboradore::class,'colab_unidades');
    }
}
