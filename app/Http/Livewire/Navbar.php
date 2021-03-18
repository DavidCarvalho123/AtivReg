<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{

    public $titulo = '';
    protected $listeners = ['PaginaPrincipal'];

    public function PaginaPrincipal()
    {
        $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
        foreach($colaboradores as $obj)
        {
            $this->titulo = 'Página principal - '.$obj->unidades->first()->unidade;
        }
    }

    public function mount()
    {
        $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
        foreach($colaboradores as $obj)
        {
            foreach($obj->unidades as $obj2)
            {
                $this->titulo = 'Página principal - '.$obj2->unidade;
            }

        }
        //foreach($colaboradores as $obj)
       //{
        //    dd($obj->unidades);
       //}
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
