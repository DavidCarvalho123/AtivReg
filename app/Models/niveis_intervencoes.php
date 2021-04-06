<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class niveis_intervencoes extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $fillable = [
        'niveis_id'
    ];

    public function Niveis()
    {
        return $this->belongsTo('App\Models\Nivei');
    }
}
