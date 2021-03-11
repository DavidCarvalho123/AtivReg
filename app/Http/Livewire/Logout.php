<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{


    public function mount()
    {
        Auth::logout();
        return redirect('/');
    }
}
