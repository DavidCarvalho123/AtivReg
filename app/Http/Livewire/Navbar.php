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
    protected $listeners = ['PaginaPrincipal', 'IrRegistos', 'uni','nive','colabo','cli','fich','famil'];

    public function cli()
    {
        $this->titulo = 'Criação de clientes';
    }

    public function fich()
    {
        $this->titulo = 'Introduzão de ficheiros';
    }

    public function famil()
    {
        $this->titulo = 'Criação de contas de familiares';
    }

    public function uni()
    {
        $this->titulo = 'Criação de unidades';
    }

    public function nive()
    {
        $this->titulo = 'Criação de cargos para colaboradores';
    }

    public function colabo()
    {
        $this->titulo = 'Criação de contas de colaboradores';
    }

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
                if(Gate::allows('admin-only',Auth::user()))
                {
                    $this->titulo = 'Criação de unidades';
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
