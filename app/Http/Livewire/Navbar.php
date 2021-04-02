<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Navbar extends Component
{
    public $unidade;
    public $titulo = '';
    protected $listeners = ['PaginaPrincipal', 'IrRegistos'];

    public function PaginaPrincipal()
    {

        if($this->unidade != '')
        {
            $this->titulo = 'Página principal - '.$this->unidade;
        }
        else
        {
            $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
            foreach($colaboradores as $obj)
            {
                $this->titulo = 'Página principal - '.$obj->unidades->first()->unidade;
            }
        }

    }

    public function IrRegistos($receive, $titulo)
    {
        $this->titulo = 'Registos de '.$titulo;
    }

    public function mount()
    {

        if($this->unidade != '')
        {
            $this->titulo = 'Página principal - '.$this->unidade;
        }
        else
        {
            if(Gate::allows('multiuni-only', Auth::user())) $multiuni = 'true';
            else $multiuni = 'false';
            if($multiuni == 'false')
            {
                $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
                foreach($colaboradores as $obj)
                {
                    $this->titulo = 'Página principal - '.$obj->unidades->first()->unidade;
                }
            }
            else
            {
                $this->titulo = 'Página principal - ';
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
