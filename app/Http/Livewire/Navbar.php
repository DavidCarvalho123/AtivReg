<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{

    public $unidadeescolhida;
    public $titulo = '';
    protected $listeners = ['PaginaPrincipal', 'IrRegistos', 'refreshEntireComponent' ,'render'];

    public function refreshEntireComponent($recebido)
    {
        $this->unidadeescolhida = $recebido;
        
    }

    public function PaginaPrincipal()
    {
        $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
        foreach($colaboradores as $obj)
        {
            $this->titulo = 'Página principal - '.$obj->unidades->first()->unidade;
        }
    }

    public function IrRegistos($receive, $titulo)
    {
        $this->titulo = 'Registos de '.$titulo;
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
