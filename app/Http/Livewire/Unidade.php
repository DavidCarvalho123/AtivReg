<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Unidade extends Component
{

    public $unidades = [];
    public $selected;
    public function mount()
    {
        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();

        $this->unidades = $colaboradores->unidades->take(99);

    }

    public function entrar()
    {
        $this->validate([
            'selected' => 'required'
        ]);

        $this->emit('refreshEntireComponent', $this->selected);
    }

    public function render()
    {
        return view('livewire.unidade');
    }
}
