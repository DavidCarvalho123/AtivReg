<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Colaboradore;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use phpDocumentor\Reflection\PseudoTypes\False_;

class Interior extends Component
{

    public $unidadeescolhida;
    protected $listeners = ['PaginaPrincipal', 'IrRegistos', 'refreshEntireComponent', 'render'];
    public $aviso, $objectos, $clientes, $origem, $pesquisa, $unidade, $contatext = 0, $contaimg = 0;
    public $show = true;
    public $selectedclients = [];
    public $ids = [];

    public function refreshEntireComponent($recebido)
    {
        $this->unidadeescolhida = $recebido;
        $this->emitSelf('render');
    }

    public function mount()
    {
        $this->unidadeescolhida = '';
        //Página Principal
        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();
        if($colaboradores->unidades->count() == 1 )
        {
            foreach($colaboradores->unidades as $obj)
            {
                $this->unidadeescolhida = $obj->id;
            }
        }
        $env = new DotenvEditor();
        $this->origem = $env->getValue('DB_DATABASE2');
        $this->origem = str_replace('_', ' ', $this->origem);

        foreach($colaboradores->unidades as $obj)
        {

            $this->unidade = $obj->id;
            if($obj->pagina_principal == null) $this->aviso = 'Ainda não existe nenhum ficheiro disponivel.';
            else
            {
                $this->aviso = '';
                $this->objectos = $obj->pagina_principal->ficheiros->take(4);

            }
        }
        //END

        //Seleção de Clientes
        $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->orderBy('nome','asc')->get();
        //Registos
        $tables = DB::connection('mysql2')->select("SHOW TABLES LIKE 'intervencoes\_%'");

        foreach($tables as $object)
        {
            $arrays[] = (array) $object;
        }

        foreach($arrays as $array)
        {
            $string = '';
            $string = implode('',$array);
            $stringteste = rtrim($string,'s');
            if($colaboradores->Niveis->$stringteste->count() > 0)
            {
                $registo = DB::connection('mysql2')->select('describe '.$string);
                $this->contatext = 0;
                $this->contaimg = 0;
                foreach($registo as $a)
                {
                    if($a->Type == 'text')
                    {
                        $this->contatext++;
                    }
                    if($a->Type == 'tinyint(4)')
                    {
                        $this->contaimg++;
                    }
                }
            }
        }


        //END
    }

    public function updatedpesquisa()
    {
        if($this->pesquisa == '')
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->orderBy('nome','asc')->get();
        }
        else
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->where(function($query){$query->where('nome','like','%'.$this->pesquisa.'%')->orWhere('apelido','like','%'.$this->pesquisa.'%');})->orderBy('nome','asc')->get();

        }
    }

    public function PaginaPrincipal($receive)
    {
        $this->show = $receive;
    }

    public function IrRegistos($receive, $placeholder)
    {
        $this->show = $receive;
    }

    public function SelectCliente($selecionado)
    {

        $index = array_search($selecionado,$this->ids);

        if($index !== false)
        {
            unset($this->ids[$index]);
            $this->ids = array_values($this->ids);

        }
        else
        {
            array_push($this->ids,$selecionado);
        }


        $select = Cliente::whereIn('id', $this->ids)->orderBy('nome','asc')->get();

        $this->selectedclients = $select;
    }

    public function render()
    {
        return view('livewire.interior');
    }
}
