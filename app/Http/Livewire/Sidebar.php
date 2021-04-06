<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use App\Models\niveis_intervencoes;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Sidebar extends Component
{

    public $unidade;
    public $titulos = [];
    public $db;
    public $show, $admin, $uni, $nive, $colab, $pagpri, $viewnivel, $other1 = 0,$other2 = 0,$other3 = 0, $otherclick1, $otherclick2, $otherclick3;

    public function loadPaginaPrincipal()
    {
        if(Gate::allows('admin-only',Auth::user()))
        {
            $this->uni = 'active';
            $this->nive = '';
            $this->colab = '';
            $this->show = 4;
            $this->emit('uni',$this->show);
        }
        else
        {
            $this->pagpri = 'active';
            $this->viewnivel = '';
            $this->show = true;
            $this->emit('PaginaPrincipal', $this->show);
        }
    }


    public function mount()
    {
        if(Gate::allows('admin-only',Auth::user()))
        {
            $this->admin = 1;
        }
        else
        {
            $this->admin = 0;
        }
        $this->other1 = 0;
        $this->other2 = 0;
        $this->other3 = 0;
        $env = new DotenvEditor();
        $this->db = $env->getValue('DB_DATABASE2');
        $this->db = str_replace('_', ' ', $this->db);

        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->where('IsDeleted',0)->first();
        $tabela = 'intervencoes_'.$colaboradores->Niveis->nivel;
        if(Schema::connection('mysql2')->hasTable($tabela))
        {
            if($colaboradores->niveis_id != 1)
            {
                $tables = DB::connection('mysql2')->select("SHOW TABLES LIKE 'intervencoes\_%'");
                $arrays = [];
                foreach($tables as $object)
                {
                    $arrays[] = (array) $object;
                }

                foreach($arrays as $array)
                {
                    $string = '';
                    $string = implode('',$array);
                    $string = rtrim($string,'s');
                    $string .= '_id';
                    $verificar = niveis_intervencoes::where('niveis_id',$colaboradores->niveis_id)->first();
                    if($verificar->$string != '')
                    {
                        array_push($this->titulos, $colaboradores->Niveis->nivel);
                    }
                    else
                    {
                        // o user não tem autorização para fazer crud
                    }
                }
            }
        }
        $this->checkplace($colaboradores->Niveis);
    }

    public function checkplace($niveis)
    {
        if($niveis->clientes == 1) $this->other1 = 1;
        if($niveis->ficheiros == 1) $this->other2 = 1;
        if($niveis->familiares == 1) $this->other3 = 1;
    }

    public function PaginaPrincipal()
    {
        $this->pagpri = 'active';
        $this->viewnivel = '';
        $this->otherclick1 = '';
        $this->otherclick2 = '';
        $this->otherclick3 = '';
        $this->show = 1;
        $this->emit('PaginaPrincipal', $this->show);
    }

    public function ViewNiveis($nivel)
    {
        $this->pagpri = '';
        $this->viewnivel = 'active';
        $this->otherclick1 = '';
        $this->otherclick2 = '';
        $this->otherclick3 = '';
        $this->show = 0;
        $this->emit('IrRegistos', $this->show, $nivel);
    }

    public function ClickUnidades()
    {
        $this->uni = 'active';
        $this->nive = '';
        $this->colab = '';
        $this->otherclick1 = '';
        $this->otherclick2 = '';
        $this->otherclick3 = '';
        $this->show = 4;
        $this->emit('uni',$this->show);
    }

    public function ClickNiveis()
    {
        $this->uni = '';
        $this->nive = 'active';
        $this->colab = '';
        $this->otherclick1 = '';
        $this->otherclick2 = '';
        $this->otherclick3 = '';
        $this->show = 5;
        $this->emit('nive',$this->show);
    }

    public function ClickColab()
    {
        $this->uni = '';
        $this->nive = '';
        $this->colab = 'active';
        $this->otherclick1 = '';
        $this->otherclick2 = '';
        $this->otherclick3 = '';
        $this->show = 6;
        $this->emit('colabo',$this->show);
    }

    public function Clickother1()
    {
        $this->pagpri = '';
        $this->viewnivel = '';
        $this->uni = '';
        $this->nive = '';
        $this->colab = '';
        $this->otherclick1 = 'active';
        $this->otherclick2 = '';
        $this->otherclick3 = '';
        $this->show = 7;
        $this->emit('cli',$this->show);
    }

    public function Clickother2()
    {
        $this->pagpri = '';
        $this->viewnivel = '';
        $this->uni = '';
        $this->nive = '';
        $this->colab = '';
        $this->otherclick1 = '';
        $this->otherclick2 = 'active';
        $this->otherclick3 = '';
        $this->show = 8;
        $this->emit('fich',$this->show);
    }

    public function Clickother3()
    {
        $this->pagpri = '';
        $this->viewnivel = '';
        $this->uni = '';
        $this->nive = '';
        $this->colab = '';
        $this->otherclick1 = '';
        $this->otherclick2 = '';
        $this->otherclick3 = 'active';
        $this->show = 9;
        $this->emit('famil',$this->show);
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
