<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use App\Models\Familiare;
use App\Models\Unidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Unidade extends Component
{

    public $unidades = [];
    public $selected;
    public function mount()
    {
        if(Auth::user()->IsFamil == 0)
        {
            $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();
            $this->unidades = $colaboradores->unidades->take(100);
        }
        else
        {
            $a = Familiare::where('nome_utilizador',Auth::user()->email)->first();
            foreach($a->clientes as $b)
            {
                dd($b);
            }
        }



    }

    public function entrar()
    {
        $this->validate([
            'selected' => 'required'
        ]);
        $unidadeselecionado = Unidades::select('unidade')->where('id','=',$this->selected)->first();
        session()->flash('a', $unidadeselecionado->unidade);
        return redirect()->to('/dashboard');
    }

    public function render()
    {
        return view('livewire.unidade');
    }
}
