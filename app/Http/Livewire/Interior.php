<?php

namespace App\Http\Livewire;


use App\Models\Cliente;
use App\Models\Colaboradore;
use App\Models\ColabUnidade;
use App\Models\FicheirosPaginaprincipal;
use App\Models\fotos;
use App\Models\Grupo;
use App\Models\intervencoesgrupo;
use App\Models\intervencoesindividuai;
use App\Models\Nivei;
use App\Models\niveis_intervencoes;
use App\Models\Pagina_Principal;
use App\Models\Unidades;
use App\Models\User;
use Brotzka\DotenvEditor\DotenvEditor;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Interior extends Component
{
    use WithFileUploads;
    protected $listeners = ['PaginaPrincipal', 'IrRegistos', 'updatedpesquisa', 'refreshJS', 'uni', 'nive', 'colabo','cli','fich','famil'];
    public $aviso, $aviso2, $objectos, $clientes, $origem, $pesquisaNome, $pesquisaApelido, $pesquisaNomeGrupo, $unidade, $registo, $fotos = [], $erro, $erro2, $stringtable, $conta = 0;
    public $vartext = [], $vartext2 = [], $varchoose2 = [], $varchoose = [], $datachoose, $hoin, $hofi, $stringtable2, $titulo;
    public $show = true, $colaboradoresId,$allclients, $allvalues, $registoid, $qualdeles, $idselecionado, $indi2;
    public $selectedclients = [], $javas = 0, $grupo, $grupoid, $allfotos, $edit, $nivelglobal;
    public $ids = [], $idgrupos = [], $gruposcolaborador, $gruposcolaborador2, $regrecente, $clientesrecentes, $interrecentes;

    public $todasunidades,$errouni, $sigla, $uninome, $nrtelemovel, $uniemail, $siglaantiga, $fechar;
    public $check4, $texto, $escolha, $cargo, $podecli, $podefich, $podefamil, $textarray = [], $escolharray = [], $erronivel, $todosniveis;
    public $cargocolab2, $emailcolab, $nomecolab, $apelidocolab, $cargocolab, $errocolab, $todoscolabs, $passtemp, $todosuni, $unidadecolab, $colabpararemover, $paraeditar, $emailantigo;

    public $errofich, $ficheiros, $nomefich, $descfich, $unifich;

    public function mount()
    {
        $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->where('IsDeleted',0)->first();
        $this->colaboradoresId = $colaboradores->id;
        $env = new DotenvEditor();
        $this->origem = $env->getValue('DB_DATABASE2');

        if(Gate::allows('admin-only',Auth::user()))
        {
            $this->uni(4);
        }
        else
        {
            $this->aviso = 'Ainda não existe nenhum ficheiro disponivel';
            //Página Principal
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
                    if($obj->pagina_principal->ficheiros->count() < 1) $this->aviso = 'Ainda não existe nenhum ficheiro disponivel.';
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
            $tabela = 'intervencoes_'.$colaboradores->Niveis->nivel;
            if(Schema::connection('mysql2')->hasTable($tabela))
            {
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
                    $string2 .= '_id';
                    $verificar = niveis_intervencoes::where('niveis_id',$colaboradores->niveis_id)->first();
                    if($verificar->$string2 != '')
                    {
                        $this->stringtable2 = $string;
                        $this->registo = DB::connection('mysql2')->select('describe '.$string);
                        $this->nivelglobal = $colaboradores->Niveis->nivel;
                    }
                }
            }
        }
    }







    public function cli($receive)
    {
        $this->show = $receive;
    }

    public function updatingficheiros()
    {
        $this->errofich = '';
    }

    public function submitfich()
    {
        $this->errofich = '';
        try
        {
            $this->validate([
                'ficheiros' => 'required|file',
            ]);
        }
        catch(Exception $e){
            $this->erro = 'Um dos ficheiros introduzidos tem um formato inválido, apenas pode introduzir imagens.';
            return;
        }

    }

    public function fich($receive)
    {
        $this->show = $receive;
        $id = Colaboradore::where('email',Auth::user()->email)->first();
        $array2 = [];
        foreach($id->unidades as $uni)
        {
            array_push($array2,$uni->id);
        }
        $this->todosuni = Unidades::whereIn('id',$array2)->get();
    }

    public function famil($receive)
    {
        $this->show = $receive;
    }























    public function uni($receive)
    {
        $this->show = $receive;
        $this->todasunidades = Unidades::get();
    }

    public function removeunidade($idrecebido)
    {
        $validar = Cliente::where('unidades_id',$idrecebido)->get();
        if($validar->count() > 0)
        {
            $this->javas = 12;
            return;
        }
        $validar = ColabUnidade::where('unidades_id',$idrecebido)->get();
        if($validar->count() > 0)
        {
            $this->javas = 12;
            return;
        }
        $validar = FicheirosPaginaprincipal::where('pagina__principal_id',$idrecebido)->get();
        if($validar->count() > 0)
        {
            $this->javas = 12;
            return;
        }
        Pagina_Principal::where('unidades_id',$idrecebido)->delete();
        Unidades::where('id',$idrecebido)->delete();
        $this->javas = 13;
        $this->uni(4);
    }

    public function Cloneuni($idrecebido)
    {
        $paraeditar = Unidades::where('id',$idrecebido)->first();
        $this->sigla = $paraeditar->id;
        $this->uninome = $paraeditar->unidade;
        $this->nrtelemovel = $paraeditar->nr_telefone;
        $this->uniemail = $paraeditar->email;
        $this->siglaantiga = $paraeditar->id;
        $this->fechar = 'disabled';
        $this->edit = 1;
    }

    public function clonecolab($recebido)
    {
        $this->paraeditar = Colaboradore::where('id',$recebido)->first();
        $this->emailantigo = $this->paraeditar->email;
        $this->emailcolab = $this->paraeditar->email;
        $this->nomecolab = $this->paraeditar->nome;
        $this->apelidocolab = $this->paraeditar->apelido;
        $this->cargocolab2 = $this->paraeditar->Niveis;
        $this->edit = 1;
    }

    public function unicreate()
    {
        $this->errouni = '';
        try
        {
            $this->validate([
                'sigla' => 'max:12'
            ]);
        }
        catch(Exception $e)
        {
            $this->errouni = 'A sigla tem que ter menos de 12 caractéres';
            return;
        }
        if($this->edit == 1)
        {
            $reg = Unidades::where('id',$this->siglaantiga)->first();
            $reg->update([
                'unidade' => $this->uninome,
                'nr_telefone' => $this->nrtelemovel,
                'email' => $this->uniemail,
            ]);

            $this->javas = 14;
        }
        else
        {
            $validar = Unidades::where('id',$this->sigla)->get();
            if($validar->count() > 0)
            {
                $this->errouni = 'A sigla introduzida já existe';
                return;
            }
            $validar = Unidades::where('id',$this->uninome)->get();
            if($validar->count() > 0)
            {
                $this->errouni = 'O nome da unidade introduzida já existe';
                return;
            }
            Unidades::create([
                'id' => $this->sigla,
                'unidade' => $this->uninome,
                'nr_telefone' => $this->nrtelemovel,
                'email' => $this->uniemail,
            ]);
            Pagina_Principal::create([
                'unidades_id' => $this->sigla,
            ]);
            $this->javas = 11;
        }
        $this->sigla = '';
        $this->uninome = '';
        $this->nrtelemovel = '';
        $this->uniemail = '';
        $this->fechar = '';
        $this->edit = 0;
        $this->uni(4);
    }

    public function nive($receive)
    {
        $this->show = $receive;
        $this->todosniveis = Nivei::get();
    }

    public function RemoveCargos($receive)
    {

        $colabsnivel = Colaboradore::where('niveis_id',$receive)->where('IsDeleted',0)->get();
        if($colabsnivel->count() > 0)
        {
            $this->javas = 24;
            return;
        }
        $niveis = Nivei::where('id',$receive)->first();
        $contador = $niveis->id - 1;
        $m = Nivei::where('id',$receive)->first();
        //verificar se a table existe
        $tabela = 'intervencoes_'.$m->nivel;
        if(Schema::connection('mysql2')->hasTable($tabela))
        {
            // existe
            $query = "ALTER TABLE $this->origem.intervencoesentidades DROP FOREIGN KEY intervencoesentidades_ibfk_$contador";
            DB::statement($query);
            $query = "ALTER TABLE $this->origem.intervencoesentidades DROP COLUMN id_$m->nivel";
            DB::statement($query);
            $query = "DELETE FROM $this->origem.niveis_intervencoes WHERE intervencoes_".$m->nivel."_id != ''";
            DB::statement($query);
            $query = "ALTER TABLE $this->origem.niveis_intervencoes DROP FOREIGN KEY niveis_intervencoes_ibfk_$contador";
            DB::statement($query);
            $query = "ALTER TABLE $this->origem.niveis_intervencoes DROP COLUMN intervencoes_".$m->nivel."_id";
            DB::statement($query);
            $query = "DROP TABLE $this->origem.intervencoes_$m->nivel";
            DB::statement($query);
        }
        else
        {
            // n existe, utilizador não efetua registos

        }

        Nivei::where('id',$receive)->delete();
        $adm = Nivei::where('nivel','!=','Admin')->get();
        if($adm->count() == 0)
        {
            $query = "ALTER TABLE $this->origem.niveis AUTO_INCREMENT = 2";
            DB::statement($query);
        }
        $this->javas = 25;
        $this->nive(5);
    }

    public function nivelsubmit()
    {
        $this->cargo = str_replace(' ','',$this->cargo);
        $this->cargo = strtolower($this->cargo);
        $this->erronivel = '';
        $validar = Nivei::where('nivel',$this->cargo)->get();
        if($validar->count() > 0)
        {
            $this->erronivel = 'O cargo introduzido já existe';
            return;
        }
        if($this->podecli == true) $this->podecli = 1;
        else $this->podecli = 0;
        if($this->podefich == true) $this->podefich = 1;
        else $this->podefich = 0;
        if($this->podefamil == true) $this->podefamil = 1;
        else $this->podefamil = 0;
        $query = "SET character_set_server = 'utf8'";
        DB::statement($query);
        date_default_timezone_set('Europe/Lisbon');
        $now = date('Y-m-d H:i:s');
        $query = "INSERT INTO $this->origem.niveis (nivel,clientes,ficheiros,familiares,created_at) VALUES ('".$this->cargo."','".$this->podecli."','".$this->podefich."','".$this->podefamil."','".$now."')";
        DB::statement($query);
        if($this->texto > 0 OR $this->escolha > 0)
        {
            // Criar tabela e relações polimorfismo
            $a = substr($this->cargo,0,3);
            $string = $a.'0';
            $query = "CREATE TABLE $this->origem.intervencoes_$this->cargo (id VARCHAR(7) NOT NULL, PRIMARY KEY (id)) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'";
            DB::statement($query);
            $query = "INSERT INTO $this->origem.intervencoes_$this->cargo (id) VALUES ('$string')";
            DB::statement($query);
            for($i = 1;$i <= $this->texto; $i++)
            {
                $query = 'ALTER TABLE '.$this->origem.'.intervencoes_'.$this->cargo.' ADD '.$this->textarray[$i].' TEXT NULL';
                DB::statement($query);
                $query = "UPDATE $this->origem.intervencoes_$this->cargo SET ".$this->textarray[$i]." = 'NÃO APAGAR' WHERE id = '".$string."'";
                DB::statement($query);
            }
            for($i = 1;$i <= $this->escolha; $i++)
            {
                $query = 'ALTER TABLE '.$this->origem.'.intervencoes_'.$this->cargo.' ADD '.$this->escolharray[$i].' TINYINT(4) NULL';
                DB::statement($query);
                $query = "UPDATE $this->origem.intervencoes_$this->cargo SET ".$this->escolharray[$i]." = '0' WHERE id = '$string'";
                DB::statement($query);
            }
            $query = 'ALTER TABLE '.$this->origem.'.intervencoes_'.$this->cargo.' ADD created_at TIMESTAMP';
            DB::statement($query);
            $now = date('Y-m-d H:i:s');
            $query = "UPDATE $this->origem.intervencoes_$this->cargo SET created_at = '$now'";
            DB::statement($query);
            $query = 'ALTER TABLE '.$this->origem.'.niveis_intervencoes ADD intervencoes_'.$this->cargo.'_id VARCHAR(7) NULL';
            DB::statement($query);
            $query = 'ALTER TABLE '.$this->origem.'.niveis_intervencoes ADD FOREIGN KEY (intervencoes_'.$this->cargo.'_id) REFERENCES '.$this->origem.'.intervencoes_'.$this->cargo.'(id) ON DELETE CASCADE';
            DB::statement($query);
            $lastid = Nivei::latest('created_at')->first();
            $query = "INSERT INTO $this->origem.niveis_intervencoes (niveis_id,intervencoes_".$this->cargo."_id) VALUES ('$lastid->id','$string')";
            DB::statement($query);
            $query = 'ALTER TABLE '.$this->origem.'.intervencoesentidades ADD id_'.$this->cargo.' VARCHAR(7) NULL ';
            DB::statement($query);
            $query = 'ALTER TABLE '.$this->origem.'.intervencoesentidades ADD FOREIGN KEY (id_'.$this->cargo.') REFERENCES '.$this->origem.'.intervencoes_'.$this->cargo.'(id) ON DELETE CASCADE';
            DB::statement($query);
        }
        $this->cargo = '';
        $this->texto = 0;
        $this->escolha = 0;
        $this->podecli = 0;
        $this->podefamil = 0;
        $this->podefich = 0;
        $this->check4 = 0;
        $this->textarray = [];
        $this->escolharray = [];
        $this->javas = 23;
        $this->nive(5);
    }

    public function colabremoveget($receive)
    {
        $this->colabpararemover = Colaboradore::where('id',$receive)->first();
    }

    public function colabremove()
    {
        $this->colabpararemover->update([
            'niveis_id' => null,
            'IsDeleted' => 1,
        ]);
        User::where('email',$this->colabpararemover->email)->delete();
        $this->javas = 22;
        $this->colabo(6);
    }

    public function colabo($receive)
    {
        $this->show = $receive;
        $this->todosniveis = Nivei::get();
        $this->todoscolabs = Colaboradore::where('IsDeleted',0)->orderBy('nome','asc')->get();
        $this->todosuni = Unidades::get();
    }

    public function colabsubmit()
    {
        $this->errocolab = '';
        if($this->edit == 0)
        {
            try
            {
                $this->validate([
                    'cargocolab' => 'required',
                ]);
            }
            catch(Exception $e)
            {
                $this->errocolab = 'O colaborador tem que ter um cargo atribuido';
                return;
            }
        }
        try
        {
            $this->validate([
                'unidadecolab' => 'required',
            ]);
        }
        catch(Exception $e)
        {
            $this->errocolab = 'O colaborador tem que pertencer a pelo menos uma unidade';
            return;
        }
        if($this->edit == 1)
        {
            $emailrepetido = Colaboradore::where('email',$this->emailcolab)->where('email','!=',$this->emailantigo)->where('IsDeleted',0)->get();
            if($emailrepetido->count() > 0)
            {
                $this->errocolab = 'O email submetido já existe';
                return;
            }
            $colabparaeditar = Colaboradore::where('email',$this->emailantigo)->first();
            $colabparaeditar->update([
                'email' => $this->emailcolab,
                'nome' => $this->nomecolab,
                'apelido' => $this->apelidocolab,
                'niveis_id' => $this->cargocolab2->id,
                'IsDeleted' => 0,
            ]);
            ColabUnidade::where('colaboradore_id',$colabparaeditar->id)->delete();
            foreach($this->unidadecolab as $uni)
            {
                $colabparaeditar->unidades()->attach($uni);
            }
            $usereditar = User::where('email',$this->emailantigo)->first();
            $usereditar->update([
                'name' => $this->nomecolab,
                'email' => $this->emailcolab,
            ]);
        }
        else
        {
            $emailrepetido = Colaboradore::where('email',$this->emailcolab)->where('IsDeleted',0)->get();
            if($emailrepetido->count() > 0)
            {
                $this->errocolab = 'O email submetido já existe';
                return;
            }
            Colaboradore::create([
                'email' => $this->emailcolab,
                'nome' => $this->nomecolab,
                'apelido' => $this->apelidocolab,
                'niveis_id' => $this->cargocolab,
                'IsDeleted' => 0,
                ]);
            $colabs = Colaboradore::latest('created_at')->first();
            foreach($this->unidadecolab as $uni)
            {
                $colabs->unidades()->attach($uni);
            }
            User::create([
                'db' => $this->origem,
                'name' => $this->nomecolab,
                'email' => $this->emailcolab,
                'password' => $this->passtemp,
            ]);
        }
        $this->javas = 21;
        $this->emailcolab = '';
        $this->nomecolab = '';
        $this->apelidocolab = '';
        $this->passtemp = '';
        $this->cargocolab = '';
        $this->unidadecolab = '';
        $this->edit = 0;
        $this->colabo(6);
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
                    try
                    {
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


                    if($this->edit == 1)
                    {
                        if($this->indi2 == 1) $inter = intervencoesindividuai::where('id',$this->idselecionado)->first();
                        else $inter = intervencoesgrupo::where('id',$this->idselecionado)->first();
                        $tableselected = DB::connection('mysql2')->table($string)->where('id',$inter->infoable_id)->first();
                        $new_id = $tableselected->id;
                    }
                    else
                    {
                        $tableselected = DB::connection('mysql2')->table($string)->latest('created_at')->first();
                        $idint = substr($tableselected->id, -1);
                        $a = substr($tableselected->id,0,-1);
                        $idint++;
                        $new_id = $a.$idint;
                    }


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

                    if($this->edit == 1)
                    {
                        if($this->indi2 == 1)
                        {
                            $todasfotos = fotos::where('intervencao_individuai_id',$this->idselecionado)->get();
                            foreach($todasfotos as $fotosa)
                            {
                                Storage::delete('public/'.$this->origem.'/'.$this->unidade.'/fotos/'.$fotosa->link);
                            }
                            fotos::where('intervencao_individuai_id',$this->idselecionado)->delete();
                        }
                        else
                        {
                            $todasfotos = fotos::where('intervencao_grupo_id',$this->idselecionado)->get();
                            foreach($todasfotos as $fotosa)
                            {
                                Storage::delete('public/'.$this->origem.'/'.$this->unidade.'/fotos/'.$fotosa->link);
                            }
                            fotos::where('intervencao_grupo_id',$this->idselecionado)->delete();
                        }
                        if($this->indi2 == 1) $inter = intervencoesindividuai::where('id',$this->idselecionado)->first();
                        else $inter = intervencoesgrupo::where('id',$this->idselecionado)->first();

                        foreach($newarray as $key => $val)
                        {
                            DB::connection('mysql2')->table($string)->where('id',$inter->infoable_id)->update([
                                $key => $val,
                            ]);
                        }
                    }
                    else
                    {
                        DB::connection('mysql2')->table($string)->insert([
                            $newarray,
                        ]);
                    }

                    // Guardar na individual ou grupo
                    $string = rtrim($string,'s');
                    $string = 'App\Models\\'.$string;

                    if(count($this->selectedclients) == 1)
                    {
                        //individual
                        if($this->edit == 1)
                        {
                            if($this->indi2 == 0)
                            {
                                // vem do grupo mas ficou individual
                                intervencoesgrupo::where('id',$this->idselecionado)->delete();

                                $tableselected = $string::latest('created_at')->first();
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
                            }
                            else
                            {
                                $tableselected = $string::latest('created_at')->where('id',$inter->infoable_id)->first();
                                foreach($this->selectedclients as $selectedclient)
                                {
                                    $tableselected->intervencoesindividuais()->update([
                                        'data_realizada' => $this->datachoose,
                                        'hora_iniciada' => $horin,
                                        'hora_terminada' => $horfi,
                                        'cliente_id' => $selectedclient['id'],
                                        'colaborador_id' => $this->colaboradoresId,
                                    ]);
                                }
                            }

                        }
                        else
                        {
                            $tableselected = $string::latest('created_at')->first();
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
                        }
                        //fotos individual
                        if($this->edit == 1)
                        {
                            if($this->indi2 == 0) $intervgru = intervencoesindividuai::latest('created_at')->first();
                            else $intervgru = intervencoesindividuai::latest('created_at')->where('id',$this->idselecionado)->first();
                        }
                        else $intervgru = intervencoesindividuai::latest('created_at')->first();

                        foreach ($this->fotos as $foto)
                        {
                            $origname = $foto->getClientOriginalName();
                            $ext = $foto->extension();
                            $imgnome = Str::random();
                            $imgnome = $imgnome.'.'.$ext;
                            $foto->storeAs('public/'.$this->origem.'/'.$this->unidade.'/fotos', $imgnome);
                            fotos::create([
                                'nome_foto' => $origname,
                                'link' => $imgnome,
                                'intervencao_individuai_id' => $intervgru->id,
                            ]);
                        }
                    }
                    else
                    {
                        //grupo
                        if($this->edit == 1)
                        {
                            if($this->indi2 == 1)
                            {
                                // vem do individual mas foi adicionado mais um cliente
                                intervencoesindividuai::where('id',$this->idselecionado)->delete();
                                $tableselected = $string::where('id',$inter->infoable_id)->first();
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
                            }
                            else
                            {
                                $tableselected = $string::where('id',$inter->infoable_id)->first();
                                $tableselected->intervencoesgrupo()->update([
                                    'data_realizada' => $this->datachoose,
                                    'hora_iniciada' => $horin,
                                    'hora_terminada' => $horfi,
                                    'colaborador_id' => $this->colaboradoresId,
                                ]);
                                $intervgru = intervencoesgrupo::where('id',$this->idselecionado)->first();
                                foreach($this->selectedclients as $selectedclient)
                                {
                                    $clientss[$selectedclient['id']] = ['id' => $selectedclient['id']];
                                }
                                $intervgru->Clientes()->sync($clientss);
                            }
                        }
                        else
                        {
                            $tableselected = $string::latest('created_at')->first();
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
                        }
                        //fotos grupos
                        if($this->edit == 1)
                        {
                            if($this->indi2 == 1) $intervgru = intervencoesgrupo::latest('created_at')->first();
                            else $intervgru = intervencoesgrupo::latest('created_at')->where('id',$this->idselecionado)->first();
                        }
                        else $intervgru = intervencoesgrupo::latest('created_at')->first();

                        foreach ($this->fotos as $foto)
                        {
                            $origname = $foto->getClientOriginalName();
                            $ext = $foto->extension();
                            $imgnome = Str::random();
                            $imgnome = $imgnome.'.'.$ext;
                            $foto->storeAs('public/'.$this->origem.'/'.$this->unidade.'/fotos', $imgnome);
                            fotos::create([
                                'nome_foto' => $origname,
                                'link' => $imgnome,
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
                    if($this->edit == 1) $this->javas = 7;
                    else $this->javas = 1;


                    $this->edit = 0;
                }
            }


        }
    }







    public function tabelas($va)
    {

        if($va == 1)
        {
            $this->show = 3;
            $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
            $uninome = Unidades::where('id','=',$this->unidade)->first();
            $this->titulo = $uninome->unidade;


            if($this->unidade != '')
            {
                $unidadeselecionado = Unidades::where('id',$this->unidade)->first();
                $this->unidade = $unidadeselecionado->id;
                if($unidadeselecionado->pagina_principal == null) $this->aviso = 'Ainda não existe nenhum ficheiro disponivel.';
                else
                {
                    $this->aviso = '';
                    $this->objectos = $unidadeselecionado->pagina_principal->ficheiros;

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
                        $this->objectos = $obj->pagina_principal->ficheiros;

                    }
                }
            }

        }
        else
        {
            $this->show = 2;
            $string = $this->stringtable2;
            $this->allvalues = DB::connection('mysql2')->table($string)->skip(1)->take(PHP_INT_MAX)->get();
            $contatext = 0;
            $contachoose = 0;
            $this->vartext2 = [];
            $this->varchoose2 = [];
            foreach($this->allvalues as $n)
            {
                foreach($this->registo as $a)
                {
                    if($a['Type'] == 'text')
                    {
                        $placehold = $a['Field'];
                        $this->vartext2 += [ $contatext => $n->$placehold ];
                        $contatext++;
                    }
                    if($a['Type'] == 'tinyint(4)')
                    {
                        $placehold = $a['Field'];
                        $this->varchoose2 += [$contachoose => $n->$placehold];
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










    public function Clone($recenteid, $indi, $editar)
    {
        $this->indi2 = $indi;
        if($editar == 1)
        {
            $this->edit = 1;
            $this->idselecionado = $recenteid;
        }
        else
        {
            $this->edit = 0;
            $this->idselecionado = '';
        }

        if($indi == 1)
        {
            // id do individual
            $interindi = intervencoesindividuai::where('id',$recenteid)->first();
            $this->datachoose = $interindi->data_realizada;
            $this->hoin = substr($interindi->hora_iniciada,0,-3);
            $this->hofi = substr($interindi->hora_terminada,0,-3);
            $this->ids = array();
            $this->conta = 0;
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
            $this->hoin = substr($intergrup->hora_iniciada,0,-3);
            $this->hofi = substr($intergrup->hora_terminada,0,-3);
            $clients = $intergrup->Clientes()->get();
            $this->ids = array();
            $this->conta = 0;
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

        $this->emit('IrRegistos',0,$this->nivelglobal);
    }

    public function maisrecentes()
    {
        $x = intervencoesindividuai::where('colaborador_id',$this->colaboradoresId)->get();
        $z = intervencoesgrupo::where('colaborador_id',$this->colaboradoresId)->get();
        $c = $x->concat($z);
        $this->allfotos = fotos::get();
        $this->regrecente = $c->sortByDesc('created_at');
        if($this->regrecente->count() < 1) $this->aviso2 = 'Ainda não criou nenhum registo';
        else $this->aviso2 = '';
        $this->regrecente = $this->regrecente->take(14);
        $this->regrecente = $this->regrecente->toArray();
        $this->clientesrecentes = Cliente::where('unidades_id', '=', $this->unidade)->orderBy('nome','asc')->get();
        $this->interrecentes = intervencoesgrupo::where('colaborador_id', $this->colaboradoresId)->get();

    }


    public function cleanfiles()
    {
        $this->fotos = array();
        $this->dispatchBrowserEvent('cleanfiles');
    }

    public function cleanfiles2()
    {
        $this->ficheiros = '';
        $this->dispatchBrowserEvent('cleanfiles2');
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

    public function getremoveregisto($registoselecionado, $indi2)
    {
        $this->registoid = $registoselecionado;
        $this->qualdeles = $indi2;
    }

    public function RemoveRegisto()
    {
        if($this->qualdeles == 1)
        {
            $todasfotos = fotos::where('intervencao_individuai_id',$this->registoid)->get();
            foreach($todasfotos as $fotosa)
            {
                Storage::delete('public/'.$this->origem.'/'.$this->unidade.'/fotos/'.$fotosa->link);
            }
            fotos::where('intervencao_individuai_id',$this->registoid)->delete();
            $info = intervencoesindividuai::where('id',$this->registoid)->first();
            $string = $this->stringtable2;
            DB::connection('mysql2')->table($string)->where('id',$info->infoable_id)->delete();
            intervencoesindividuai::where('id',$this->registoid)->delete();
        }
        else
        {
            $todasfotos = fotos::where('intervencao_grupo_id',$this->registoid)->get();
            foreach($todasfotos as $fotosa)
            {
                Storage::delete('public/'.$this->origem.'/'.$this->unidade.'/fotos/'.$fotosa->link);
            }
            fotos::where('intervencao_grupo_id',$this->registoid)->delete();
            $info = intervencoesgrupo::where('id',$this->registoid)->first();
            $string = $this->stringtable2;
            DB::connection('mysql2')->table($string)->where('id',$info->infoable_id)->delete();
            intervencoesgrupo::where('id',$this->registoid)->delete();
        }


        $this->javas = 6;
        $this->maisrecentes();
        $this->tabelas(0);
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
        $colaboradores = Colaboradore::find(1)->where('email', '=', Auth::user()->email)->get();
        if($this->unidade != '')
            {
                $unidadeselecionado = Unidades::where('id',$this->unidade)->first();
                $this->unidade = $unidadeselecionado->id;
                if($unidadeselecionado->pagina_principal->ficheiros->count() < 1) $this->aviso = 'Ainda não existe nenhum ficheiro disponivel.';
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
            $string .= '_id';
            $verificar = niveis_intervencoes::where('niveis_id',$nivel->id)->first();
            if($verificar->$string != '')
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
