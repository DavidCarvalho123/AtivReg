<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoesgrupo extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'data_realizada','hora_iniciada','hora_terminada','info_id','colaborador_id'
    ];

    protected $casts=[
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function Clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_intervencoesgrupos');
    }

    public function fotos()
    {
        return $this->hasMany('App\Models\fotos');
    }

    public function colaboradores()
    {
        return $this->belongsTo('App\Models\Colaboradore');
    }

    public function infoable()
    {
        return $this->morphTo();
    }

}
