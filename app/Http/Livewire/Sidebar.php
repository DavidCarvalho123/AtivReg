<?php

namespace App\Http\Livewire;

use App\Models\Colaboradore;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Sidebar extends Component
{

    public $unidade;
    public $titulos = [];
    public $db;
    public $show;

    public function loadPaginaPrincipal()
    {
        $this->show = true;
        $this->emit('PaginaPrincipal', $this->show);
    }


    public function mount()
    {
        $env = new DotenvEditor();
        $this->db = $env->getValue('DB_DATABASE2');
        $this->db = str_replace('_', ' ', $this->db);

        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();


        $tables = DB::connection('mysql2')->select("SHOW TABLES LIKE 'intervencoes\_%'");

        foreach($tables as $object)
        {
            $arrays[] = (array) $object;
        }

        foreach($arrays as $array)
        {
            $string = '';
            $string = implode('',$array);
            $string = rtrim($string,'s');

            if($colaboradores->Niveis->$string->count() > 0)
            {
                //foreach($colaboradores->Niveis->$string as $obj)
                //{
                //    $test[] = $obj->id;
                //    // resto do codigo V
                //    dd($test);
                //}
                array_push($this->titulos, $colaboradores->Niveis->nivel);

            }
            else
            {
                // o user não tem autorização para fazer crud
            }
        }
    }

    public function PaginaPrincipal()
    {
        $this->show = 1;
        $this->emit('PaginaPrincipal', $this->show);
    }

    public function ViewNiveis($nivel)
    {

        $this->show = 0;
        $this->emit('IrRegistos', $this->show, $nivel);
    }

    public function render()
    {

        return view('livewire.sidebar');
    }
}
