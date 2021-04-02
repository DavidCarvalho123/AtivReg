<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervencoesindividuai extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable=[
        'data_realizada', 'hora_iniciada', 'hora_terminada', 'info_id', 'cliente_id','colaborador_id'
    ];

    protected $guarded = [];

    protected $casts=[
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function fotos()
    {
        return $this->hasMany('App\Models\fotos');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
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
