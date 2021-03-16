<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Interior extends Component
{

    protected $listeners = ['PaginaPrincipal'];
    public $teste = '';

    public function PaginaPrincipal()
    {
        $this->teste = 'estou na pagina principal';
    }

    public function render()
    {
        return view('livewire.interior');
    }
}
