<?php

namespace App\Http\Livewire;

use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{


    public function mount()
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'DB_DATABASE2' => '',
        ]);
        Auth::logout();
        return redirect('/');
    }
}
