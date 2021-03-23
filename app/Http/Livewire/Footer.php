<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Footer extends Component
{

    public $unidadeescolhida;
    protected $listeners = ['refreshEntireComponent', 'render'];

    public function refreshEntireComponent($recebido)
    {
        $this->unidadeescolhida = $recebido;
    }

    public function mount()
    {
        $this->unidadeescolhida = '';
        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();

        if($colaboradores->unidades->count() == 1 )
        {
            foreach($colaboradores->unidades as $obj)
            {
                $this->unidadeescolhida = $obj->id;
            }
        }
    }

    public function render()
    {
        return view('livewire.footer');
    }
}
