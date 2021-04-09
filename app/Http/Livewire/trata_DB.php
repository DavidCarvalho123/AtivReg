<?php

use App\Models\Colaboradore;
use App\Models\Nivei;
use App\Models\User;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if(!function_exists('criardb'))
{
    function criardb()
    {
        Artisan::call('migrate',
        array(
        '--path' => 'database/migrations/mysql2folder',
        '--database' => 'mysql2',
        '--force' => true));

        Nivei::create([
        'nivel' => 'Admin',
        'clientes' => 0,
        'ficheiros' => 0,
        'familiares' => 0,
        ]);
        
        Colaboradore::create([
        'email' => Auth::user()->email,
        'nome' => Auth::user()->name,
        'niveis_id' => 1,
        'IsDeleted' => 0,
        ]);
    }
}



