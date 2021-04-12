<?php

namespace App\Http\Livewire;
include 'trata_DB.php';
use App\Models\Colaboradore;
use Brotzka\DotenvEditor\DotenvEditor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Login extends Component
{
    public $form = [
        'email' => '',
        'password' => '',
    ];
    public $counter = 0;
    public function submit1()
    {

        $this->validate([
            'form.email' => 'required',
            'form.password' => 'required',
        ]);



        Auth::attempt($this->form);
        if(Auth::attempt($this->form) == false)
        {
            $this->counter = 1;
            return;
        }
        else
        {
            if(Auth::user()->isFamil == 0)
            {

            }
        }



        $bd = DB::table('users')
            ->where('id', '=', Auth::user()->id)
            ->value('db');

        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $dbcheck = DB::select($query, [$bd]);
        if(empty($dbcheck))
        {
            // ver se a base de dados existe ou não
            DB::statement('create database ' .$bd.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
            criardb();
            return redirect('/unidades');
        }
        else
        {
            if(DB::table('users')->where('id','=',Auth::user()->id)->where('db','=','')->exists()){
                return redirect('/sadmin');
            }
            else
            {
                $env = new DotenvEditor();
                $env->changeEnv([
                    'DB_DATABASE2' => $bd,
                ]);

                return redirect('/unidades');
            }
        }


    }

    public function render()
    {

        return view('livewire.login');
    }
}
