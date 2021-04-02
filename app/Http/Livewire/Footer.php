<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Footer extends Component
{



    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.footer');
    }
}
