<?php

namespace App\Http\Livewire;

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
    public function submit()
    {

        $this->validate([
            'form.email' => 'required|email',
            'form.password' => 'required',
        ]);



        Auth::attempt($this->form);
        if(Auth::attempt($this->form) == false)
        {
            $this->counter = 1;
            return;
        }



        $bd = DB::table('users')
            ->where('id', '=', Auth::user()->id)
            ->value('db');


        if(DB::table('users')->where('id','=',Auth::user()->id)->where('db','=','')->exists()){
            return redirect('/sadmin');
        }
        else
        {
            $env = new DotenvEditor();
            $env->changeEnv([
                'DB_DATABASE2' => $bd,
            ]);

            return redirect('/dashboard');
        }

    }

    public function render()
    {

        return view('livewire.login');
    }
}
