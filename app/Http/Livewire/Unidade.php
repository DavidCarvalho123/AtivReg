<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
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

        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();

        $this->unidades = $colaboradores->unidades->take(100);

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
