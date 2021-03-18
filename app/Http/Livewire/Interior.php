<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Interior extends Component
{

    protected $listeners = ['PaginaPrincipal', 'IrRegistos'];
    public $teste;
    public $objectos;
    public $origem;
    public $show = true;

    public function mount()
    {
        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();

        $env = new DotenvEditor();
        $this->origem = $env->getValue('DB_DATABASE2');
        $this->origem = str_replace('_', ' ', $this->origem);

        foreach($colaboradores->unidades as $obj)
        {
            $this->objectos = $obj->pagina_principal->ficheiros;
            //array_push($this->linkfile, $obj->pagina_principal->ficheiros->first()->link);
            //array_push($this->name, $obj->pagina_principal->ficheiros->first()->nome_ficheiro);
        }
    }
    public function PaginaPrincipal($receive)
    {
        $this->teste = 'estou na pagina principal vindo do botão';
        $this->show = $receive;


    }

    public function IrRegistos($receive)
    {
        $this->teste = 'animadora';
        $this->show = $receive;


    }

    public function render()
    {
        return view('livewire.interior');
    }
}
