<?php

namespace App\Http\Livewire;


use App\Models\Cliente;
use App\Models\Colaboradore;
use App\Models\fotos;
use App\Models\Grupo;
use App\Models\intervencoesgrupo;
use App\Models\intervencoesindividuai;
use App\Models\Nivei;
use App\Models\Unidades;

use Brotzka\DotenvEditor\DotenvEditor;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Interior extends Component
{
    use WithFileUploads;
    protected $listeners = ['PaginaPrincipal', 'IrRegistos', 'updatedpesquisa', 'refreshJS'];
    public $aviso, $aviso2, $objectos, $clientes, $origem, $pesquisaNome, $pesquisaApelido, $pesquisaNomeGrupo, $unidade, $registo, $fotos = [], $erro, $erro2, $stringtable, $conta = 0;
    public $vartext = [], $varchoose = [], $datachoose, $hoin, $hofi, $stringtable2;
    public $show = true, $colaboradoresId,$allclients, $allvalues;
    public $selectedclients = [], $javas = 0, $grupo, $grupoid;
    public $ids = [], $idgrupos = [], $gruposcolaborador, $gruposcolaborador2, $regrecente, $clientesrecentes, $interrecentes;


    public function mount()
    {
        //Página Principal
        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();
        $this->colaboradoresId = $colaboradores->id;
        $env = new DotenvEditor();
        $this->origem = $env->getValue('DB_DATABASE2');

        if($this->unidade != '')
        {
            $unidadeselecionado = Unidades::where('unidade','=',$this->unidade)->first();
            $this->unidade = $unidadeselecionado->id;
            if($unidadeselecionado->pagina_principal == null) $this->aviso = 'Ainda não existe nenhum ficheiro disponivel.';
            else
            {
                $this->aviso = '';
                $this->objectos = $unidadeselecionado->pagina_principal->ficheiros->take(4);

            }
        }
        else
        {
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
        }

        // Registos Recentes


        $this->maisrecentes();


        //END

        //Seleção de Clientes
        $this->gruposcolaborador = Grupo::where('colaborador_id','=',$this->colaboradoresId)->orderBy('nome','asc')->get();
        $this->gruposcolaborador2 = $this->gruposcolaborador;
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
            $string2 = rtrim($string,'s');
            if($colaboradores->Niveis->$string2->count() > 0)
            {
                $this->stringtable2 = $string;
                $this->registo = DB::connection('mysql2')->select('describe '.$string);
            }
        }


        //END
    }







    public function tabelas($va)
    {

        if($va == 1)
        {
            $this->show = 3;
        }
        else
        {
            $this->show = 2;
            $string = $this->stringtable2;
            $this->allvalues = DB::connection('mysql2')->table($string)->get();
            $contatext = 0;
            $contachoose = 0;
            $this->vartext = [];
            $this->varchoose = [];
            foreach($this->allvalues as $n)
            {
                foreach($this->registo as $a)
                {
                    if($a['Type'] == 'text')
                    {
                        $placehold = $a['Field'];
                        $this->vartext += [ $contatext => $n->$placehold ];
                        $contatext++;
                    }
                    if($a['Type'] == 'tinyint(4)')
                    {
                        $placehold = $a['Field'];
                        $this->varchoose += [$contachoose => $n->$placehold];
                        $contachoose++;
                    }
                }
            }
            $x = intervencoesindividuai::where('colaborador_id',$this->colaboradoresId)->get();
            $z = intervencoesgrupo::where('colaborador_id',$this->colaboradoresId)->get();
            $c = $x->concat($z);
            $this->allclients = $c->sortByDesc('created_at');
            $this->allclients = $this->allclients->toArray();
        }
    }









    public function Clone($recenteid, $indi)
    {
        if($indi == 1)
        {
            // id do individual
            $interindi = intervencoesindividuai::where('id',$recenteid)->first();
            $this->datachoose = $interindi->data_realizada;
            $this->hoin = rtrim($interindi->hora_iniciada,':00');
            $this->hofi = rtrim($interindi->hora_terminada,':00');
            array_push($this->ids,$interindi->cliente_id);
            $select = Cliente::whereIn('id', $this->ids)->orderBy('nome','asc')->get()->toArray();
            $this->selectedclients = $select;
            $this->conta++;
            $this->vartext = [];
            $this->varchoose = [];
            //intervencão especifica
            $string = $this->stringtable2;
            $interespeci = DB::connection('mysql2')->table($string)->where('id',$interindi->infoable_id)->first();
            foreach($this->registo as $a)
            {
                if($a['Type'] == 'text')
                {
                    $placehold = $a['Field'];
                    $this->vartext += [ $a['Field'] => $interespeci->$placehold ];
                }
                if($a['Type'] == 'tinyint(4)')
                {
                    $placehold = $a['Field'];
                    $this->varchoose += [$a['Field'] => $interespeci->$placehold];
                }
            }
        }
        else
        {
            // id do grupo
            $intergrup = intervencoesgrupo::where('id',$recenteid)->first();
            $this->datachoose = $intergrup->data_realizada;
            $this->hoin = rtrim($intergrup->hora_iniciada,':00');
            $this->hofi = rtrim($intergrup->hora_terminada,':00');
            $clients = $intergrup->Clientes()->get();
            foreach($clients as $h)
            {
                array_push($this->ids,$h->id);
                $this->conta++;
            }
            $select = Cliente::whereIn('id', $this->ids)->orderBy('nome','asc')->get()->toArray();
            $this->selectedclients = $select;
            $this->vartext = [];
            $this->varchoose = [];
            //intervencão especifica
            $string = $this->stringtable2;
            $interespeci = DB::connection('mysql2')->table($string)->where('id',$intergrup->infoable_id)->first();
            foreach($this->registo as $a)
            {
                if($a['Type'] == 'text')
                {
                    $placehold = $a['Field'];
                    $this->vartext += [ $a['Field'] => $interespeci->$placehold ];
                }
                if($a['Type'] == 'tinyint(4)')
                {
                    $placehold = $a['Field'];
                    $this->varchoose += [$a['Field'] => $interespeci->$placehold];
                }
            }
        }

        $this->updatedpesquisaNome();
        $this->updatedpesquisaApelido();
        $todosgrupos = Grupo::where('colaborador_id','=',$this->colaboradoresId)->whereNotIn('id',$this->idgrupos)->get();
        foreach($todosgrupos as $grupostodos)
        {
            foreach($grupostodos->Clientes as $a)
            {

                if(in_array($a->id,$this->ids) == true)
                {
                    $gruposhow = false;
                }
                else
                {
                    $gruposhow = true;
                    break;
                }
            }

            if($gruposhow == false)
            {
                array_push($this->idgrupos,$grupostodos->id);
                $this->updatedpesquisaNomeGrupo();
            }
        }
        $this->show = 0;
    }

    public function maisrecentes()
    {
        $x = intervencoesindividuai::where('colaborador_id',$this->colaboradoresId)->get();
        $z = intervencoesgrupo::where('colaborador_id',$this->colaboradoresId)->get();
        $c = $x->concat($z);
        $this->regrecente = $c->sortByDesc('created_at');
        if($this->regrecente->count() < 1) $this->aviso2 = 'Ainda não criou nenhum registo';
        else $this->aviso2 = '';
        $this->regrecente = $this->regrecente->take(14);
        $this->regrecente = $this->regrecente->toArray();
        $this->clientesrecentes = Cliente::where('unidades_id', '=', $this->unidade)->orderBy('nome','asc')->get();
        $this->interrecentes = intervencoesgrupo::where('colaborador_id', $this->colaboradoresId)->get();

    }

    public function submit()
    {
        $this->erro = '';
        if(empty($this->selectedclients))
        {
            $this->erro = 'Por favor selecione um cliente para efetuar um registo.';
        }
        else
        {
            if($this->hoin == '' AND $this->hofi == '')
            {
                $horfi = null;
                $horin = null;
                $validacao = 0;

            }
            else if($this->hofi == '')
            {
                $horfi = null;
                $horin = $this->hoin;
                $validacao = 1;
            }
            else if($this->hoin == '')
            {
                $horin = null;
                $horfi = $this->hofi;
                $validacao = 1;
            }
            else
            {
                $horin = $this->hoin;
                $horfi = $this->hofi;
                $validacao = 0;
            }

            if($validacao == 1)
            {
                $this->erro= 'Os dois campos de tempo têm de estar preenchidos';
            }
            else
            {
                if($horin > $horfi)
                {
                    $this->erro = 'A hora de ínicio tem que começar antes da hora de fim.';
                }
                else
                {
                    try{
                        $this->validate([
                            'fotos.*' => 'image|max:10240',
                        ]);
                    }
                    catch(Exception $e){
                        $this->erro = 'Um dos ficheiros introduzidos tem um formato inválido, apenas pode introduzir imagens.';
                        return;
                    }

                    // guardar na intervencão especifica
                    $string = $this->stringtable.'s';

                    $tableselected = DB::connection('mysql2')->table($string)->latest('created_at')->first();
                    $idint = substr($tableselected->id, -1);
                    $a = substr($tableselected->id,0,-1);
                    $idint++;
                    $new_id = $a.$idint;

                    $newarray = ['id' => $new_id];

                    foreach($this->vartext as $key => $val)
                    {
                        $newarray += [ $key => $val ];
                    }

                    foreach($this->varchoose as $key => $val)
                    {
                        $newarray += [ $key => $val ];
                    }
                    date_default_timezone_set('Europe/Lisbon');
                    $newarray += [ 'created_at' => date('Y-m-d H:i:s')];
                    $newarray += [ 'updated_at' => date('Y-m-d H:i:s')];
                    DB::connection('mysql2')->table($string)->insert([
                        $newarray,
                    ]);



                    // Guardar na individual ou grupo
                    $string = rtrim($string,'s');
                    $string = 'App\Models\\'.$string;
                    $tableselected = $string::latest('created_at')->first();
                    if(count($this->selectedclients) == 1)
                    {
                        //individual
                        foreach($this->selectedclients as $selectedclient)
                        {
                            $tableselected->intervencoesindividuais()->create([
                                'data_realizada' => $this->datachoose,
                                'hora_iniciada' => $horin,
                                'hora_terminada' => $horfi,
                                'cliente_id' => $selectedclient['id'],
                                'colaborador_id' => $this->colaboradoresId,
                            ]);
                        }

                        //fotos individual
                        $intervgru = intervencoesindividuai::latest('created_at')->first();
                        foreach ($this->fotos as $foto)
                        {
                            $origname = $foto->getClientOriginalName();
                            $imgnome = Str::random();
                            $foto->storeAs('public/'.$this->origem.'/'.$this->unidade.'/fotos', $imgnome);
                            fotos::create([
                                'nome_foto' => $origname,
                                'link' => asset('storage/'.$this->origem.'/'.$this->unidade.'/fotos', $imgnome),
                                'intervencao_individuai_id' => $intervgru->id,
                            ]);
                        }
                    }
                    else
                    {
                        //grupo
                        $tableselected->intervencoesgrupo()->create([
                            'data_realizada' => $this->datachoose,
                            'hora_iniciada' => $horin,
                            'hora_terminada' => $horfi,
                            'colaborador_id' => $this->colaboradoresId,
                        ]);
                        $intervgru = intervencoesgrupo::latest('created_at')->first();
                        foreach($this->selectedclients as $selectedclient)
                        {
                            $intervgru->Clientes()->attach($selectedclient['id']);
                        }

                        //fotos grupos
                        $intervgru = intervencoesgrupo::latest('created_at')->first();
                        foreach ($this->fotos as $foto)
                        {
                            $origname = $foto->getClientOriginalName();
                            $imgnome = Str::random();
                            $foto->storeAs('public/'.$this->origem.'/'.$this->unidade.'/fotos', $imgnome);
                            fotos::create([
                                'nome_foto' => $origname,
                                'link' => asset('storage/'.$this->origem.'/'.$this->unidade.'/fotos', $imgnome),
                                'intervencao_grupo_id' => $intervgru->id,
                            ]);
                        }
                    }

                    $this->varchoose = array();
                    $this->vartext = array();
                    $this->cleanfiles();
                    $this->maisrecentes();

                    //notificação a dizer que a criação funcionou
                    $this->erro = '';
                    $this->javas = 1;
                }
            }


        }
    }

    public function cleanfiles()
    {
        $this->fotos = array();
        $this->dispatchBrowserEvent('cleanfiles');
    }

    public function gruposubmit()
    {

        try
        {
            $this->validate([
                'grupo' => 'required',
            ]);
        }
        catch(Exception $e)
        {
            $this->javas = 2;
            return;
        }

        $allgrupos = Grupo::where('colaborador_id','=',$this->colaboradoresId)->get();
        foreach($allgrupos as $grupos)
        {
            foreach($this->selectedclients as $selectClient)
            {
                foreach($grupos->Clientes as $a)
                {
                    if($a->id == $selectClient['id'])
                    {
                        $gruporepetido = true;
                        break;
                    }
                    else
                    {
                        $gruporepetido = false;
                    }
                }
            }
            if($gruporepetido == true)
            {
                $this->grupo = '';
                $this->javas = 4;
                return;
            }
        }

        Grupo::create([
            'nome' => $this->grupo,
            'colaborador_id' => $this->colaboradoresId,
        ]);
        $grupocriado = Grupo::latest('created_at')->first();
        foreach($this->selectedclients as $selectClient)
        {
            $grupocriado->Clientes()->attach($selectClient['id']);
        }

        $this->grupo = '';
        $this->javas = 3;
        $this->selectedclients = array();
        $this->ids = array();
        $this->conta = 0;
        $this->idgrupos = array();
        $this->updatedpesquisaNome();
        $this->updatedpesquisaApelido();
        $this->updatedpesquisaNomeGrupo();
    }
    public function getremovegrupo($gruposelecionado)
    {
        $this->grupoid = $gruposelecionado;
    }

    public function RemoveGrupo()
    {
        Grupo::where('id',$this->grupoid)->delete();


        $this->javas = 5;
        $this->updatedpesquisaNomeGrupo();
    }

    public function refreshJS()
    {
        $this->javas = 0;
    }

    public function updatedpesquisaNomeGrupo()
    {
        if($this->pesquisaNomeGrupo == '')
        {
            $this->gruposcolaborador2 = Grupo::where('colaborador_id','=',$this->colaboradoresId)->whereNotIn('id',$this->idgrupos)->orderBy('nome','asc')->get();
        }
        else
        {
            $this->gruposcolaborador2 = Grupo::where('colaborador_id','=',$this->colaboradoresId)->whereNotIn('id',$this->idgrupos)->where('nome','like','%'.$this->pesquisaNomeGrupo.'%')->orderBy('nome','asc')->get();
        }
        $this->gruposcolaborador = Grupo::where('colaborador_id','=',$this->colaboradoresId)->orderBy('nome','asc')->get();
    }

    public function updatingfotos()
    {
        $this->erro = '';
    }

    public function updatedpesquisaNome()
    {
        if($this->pesquisaNome == '' AND $this->pesquisaApelido == '')
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->whereNotIn('id',$this->ids)->orderBy('nome','asc')->get();
        }
        elseif($this->pesquisaApelido == '')
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->whereNotIn('id',$this->ids)->Where('nome','like','%'.$this->pesquisaNome.'%')->orderBy('nome','asc')->get();
        }
        else
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->whereNotIn('id',$this->ids)->where(function($query){$query->where('nome','like','%'.$this->pesquisaNome.'%')->Where('apelido','like','%'.$this->pesquisaApelido.'%');})->orderBy('nome','asc')->get();
        }
    }

    public function updatedpesquisaApelido()
    {
        if($this->pesquisaApelido == '' AND $this->pesquisaNome == '')
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->whereNotIn('id',$this->ids)->orderBy('nome','asc')->get();
        }
        elseif($this->pesquisaNome == '')
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->whereNotIn('id',$this->ids)->Where('apelido','like','%'.$this->pesquisaApelido.'%')->orderBy('nome','asc')->get();
        }
        else
        {
            $this->clientes = Cliente::where('unidades_id', '=', $this->unidade)->whereNotIn('id',$this->ids)->where(function($query){$query->where('nome','like','%'.$this->pesquisaNome.'%')->Where('apelido','like','%'.$this->pesquisaApelido.'%');})->orderBy('nome','asc')->get();
        }
    }

    public function PaginaPrincipal($receive)
    {
        $this->show = $receive;
    }

    public function IrRegistos($receive, $placeholder)
    {
        $this->show = $receive;
        $nivelp = $placeholder;
        $nivel = Nivei::where('nivel','=',$nivelp)->first();
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

            if($nivel->$string->count() > 0)
            {
                //foreach($colaboradores->Niveis->$string as $obj)
                //{
                //    $test[] = $obj->id;
                //    // resto do codigo V
                //    dd($test);
                //}
                $this->stringtable = $string;

            }
            else
            {
                // o user não tem autorização para fazer crud
            }
        }
    }

    public function SelectCliente($selecionado, $grupo)
    {
        $this->erro = '';
        if($grupo == false)
        {
            if(in_array($selecionado,$this->ids) == true)
            {

            }
            else
            {
                array_push($this->ids,$selecionado);
                $select = Cliente::whereIn('id', $this->ids)->orderBy('nome','asc')->get()->toArray();
                $this->updatedpesquisaNome();
                $this->updatedpesquisaApelido();
                $this->selectedclients = $select;
                $this->conta++;
                $todosgrupos = Grupo::where('colaborador_id','=',$this->colaboradoresId)->whereNotIn('id',$this->idgrupos)->get();
                foreach($todosgrupos as $grupostodos)
                {
                    foreach($grupostodos->Clientes as $a)
                    {

                        if(in_array($a->id,$this->ids) == true)
                        {
                            $gruposhow = false;
                        }
                        else
                        {
                            $gruposhow = true;
                            break;
                        }
                    }

                    if($gruposhow == false)
                    {
                        array_push($this->idgrupos,$grupostodos->id);
                        $this->updatedpesquisaNomeGrupo();
                    }
                }
            }
        }
        else
        {
            $gruposelected = Grupo::where('colaborador_id','=',$this->colaboradoresId)->where('id','=',$selecionado)->first();
            if(in_array($gruposelected->id,$this->idgrupos) == true)
            {

            }
            else
            {
                array_push($this->idgrupos,$gruposelected->id);
                foreach($gruposelected->Clientes as $a)
                {
                    if(in_array($a->id,$this->ids) == false)
                    {
                        $this->conta++;
                        array_push($this->ids,$a->id);
                    }
                }
                $select = Cliente::whereIn('id',$this->ids)->orderBy('nome','asc')->get()->toArray();
                $this->updatedpesquisaNomeGrupo();
                $this->updatedpesquisaNome();
                $this->updatedpesquisaApelido();
                $this->selectedclients = $select;
            }
        }
    }

    public function deSelectCliente($selecionado)
    {
        $this->erro = '';
        if(in_array($selecionado,$this->ids) == true)
        {
            $index = array_search($selecionado,$this->ids);
            unset($this->ids[$index]);
            $this->ids = array_values($this->ids);
            $this->updatedpesquisaNome();
            $this->updatedpesquisaApelido();
            $select = Cliente::whereIn('id', $this->ids)->orderBy('nome','asc')->get()->toArray();
            $this->selectedclients = $select;
            $this->conta--;
            $todosgrupos = Grupo::where('colaborador_id','=',$this->colaboradoresId)->whereIn('id',$this->idgrupos)->get();
            foreach($todosgrupos as $grupostodos)
            {
                foreach($grupostodos->Clientes as $a)
                {

                    if($a->id == $selecionado)
                    {
                        $gruposhow = true;
                        break;
                    }
                    else
                    {
                        $gruposhow = false;
                    }
                }

                if($gruposhow == true)
                {
                    $indexg = array_search($grupostodos->id,$this->idgrupos);
                    unset($this->idgrupos[$indexg]);
                    $this->idgrupos = array_values($this->idgrupos);
                    $this->updatedpesquisaNomeGrupo();
                }
            }
        }
        else
        {

        }
    }

    public function render()
    {
        return view('livewire.interior');
    }
}
