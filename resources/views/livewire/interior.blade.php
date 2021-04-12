

@if($show  == 1)
    <div>
    <!-- Pagina Principal -->
        <div class="container-fluid">
            <div class="row">
                <div @if($noregisto == 1)class="col-lg-12"@else class="col-lg-8" @endif>
                    <h3>Ficheiros mais recentes:</h3>
                    <br>
                    <div class="container">
                        <div class="row">
                            @if($aviso == '')
                                @foreach ($objectos as $objecto)
                                    <div @if($noregisto == 1)class="col-4"@else class="col" @endif style="padding-left: 0px">
                                        <div class="card" style="width: 19rem;">
                                            <?php   $nomethumb3 = substr($objecto->link, -4, strpos($objecto->link, "."));
                                            $nomethumb = 'thumb_'.$objecto->link;
                                            if($nomethumb3 == '.pdf')
                                            {
                                                $nomethumb = substr($nomethumb, 0, strpos($nomethumb, "."));
                                                $nomethumb .= '.png';
                                            }?>
                                            <img src="{{ asset('storage/'.$this->origem.'/thumbs/'.$nomethumb) }}" class="card-img-top" alt="{{ $objecto->nome_ficheiro }}">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $objecto->nome_ficheiro }}</h4>
                                                <p class="card-text">{{ $objecto->descricao_ficheiro }}</p>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-6"><a download="{{ $objecto->nome_ficheiro }}" rel="noopener noreferrer" target="_blank" href="/storage/{{ $this->origem }}/ficheiros/{{ $objecto->link }}" class="btn btn-primary btn-fill">Transferir</a></div>
                                                        <div class="col-6" style="display: flex;justify-content: center;"><a target="_blank" href="/storage/{{ $this->origem }}/ficheiros/{{ $objecto->link }}" class="btn btn-success btn-fill">Abrir</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning"  role="alert"> {{ $aviso }} </div>
                            @endif
                        </div>
                    </div>
                    @if($aviso == '')
                        <button class="btn btn-primary btn-fill" wire:click="tabelas(1)">Mostrar todos os ficheiros da unidade</button>
                    @endif
                </div>
                @if($noregisto == 0)
                    <div class="col-lg-4">
                        <h3>Registos mais recentes:</h3>
                        <br>
                    @if ($aviso2 == '')

                        <?php

                            function compare($a, $b)
                            {
                                return strtotime($b['created_at']) - strtotime($a['created_at']);
                            }

                        usort($regrecente, 'compare');?>
                            <?php  $contaaviso = 0; ?>
                            <?php $d = 't';$global = 0;?>
                        @foreach ($regrecente as $recente)
                            <?php $conta10 = 0 ?>
                            @if(array_key_exists('cliente_id',$recente))
                                <?php $h = $clientesrecentes->where('id', $recente['cliente_id'])->first();
                                if($h != null) $conta10 = 1
                                ?>
                            @else
                                @foreach ($interrecentes as $rec)
                                    @if($rec->id == $recente['id'])
                                        <?php $e = $rec->Clientes()->where('unidades_id','=',$unidade)->get(); ?>
                                        @if($e->count() > 0)
                                            <?php $conta10++;?>
                                        @endif
                                    @endif
                                @endforeach
                            @endif

                            @if($conta10 > 0)
                                <?php $d = 'z';$global = 1 ?>
                            @else
                                <?php $d = null;?>
                            @endif

                                @if ($d != null)
                                    <div class="card">
                                        <div class="card-header">
                                            @if(array_key_exists('cliente_id',$recente))
                                                <h5 class="title" style="margin-bottom: 0px;">Cliente: {{ $h->nome.' '.$h->apelido }}</h5>
                                            @else
                                                @foreach ($interrecentes as $rec)
                                                    @if ($rec->id == $recente['id'])
                                                        <?php $e = $rec->Clientes()->get() ?>
                                                        <h5 class="title" style="margin-bottom: 0px;">Clientes:
                                                            @foreach ($e as $f)
                                                                {{ $f->nome.' '.$f->apelido }},
                                                            @endforeach
                                                        </h5>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <p class="description"><?php date_default_timezone_set('Europe/Lisbon'); ?>{{ \Carbon\Carbon::parse($recente['created_at'])->diffForHumans(['parts' => 2, 'join' => true]) }}</p>
                                                </div>
                                                <div class="col-4">
                                                    @if (array_key_exists('cliente_id',$recente))
                                                        <?php $indi = 1; ?>
                                                    @else
                                                        <?php $indi = 0; ?>
                                                    @endif
                                                    <div wire:click="Clone('{{ $recente['id'] }}', {{ $indi }},'0')" class="button-container" style="padding-right: 5px;margin-bottom: 5px;">
                                                        <button style="padding-left: 8px;padding-right: 8px;" class="btn btn-warning btn-fill pull-right" type="submit">
                                                            <i class="nc-icon nc-single-copy-04" style="position: relative;top: 2px;"></i>
                                                            Clonar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                @endif
                        @endforeach
                        @if ($global == 0)
                            <?php $contaaviso++; ?>
                            @if ($contaaviso == 1)
                                <?php $aviso2 = 'Ainda não criou nenhum registo nesta unidade'; ?>
                                <div class="alert alert-warning" role="alert"> {{ $aviso2 }}. </div>
                            @endif
                        @endif

                    @else
                        <div class="alert alert-warning" role="alert"> {{ $aviso2 }}. </div>
                    @endif
                    @if($aviso2 == '')
                        <button class="btn btn-primary btn-fill" wire:click="tabelas(0)">Mostrar todos os seus registos</button>
                    @endif
                    </div>
                @endif
            </div>
        </div>

    </div>
    <!-- END -->

@elseif ($show == 0)

    <div>
    <!-- Registos -->
        <!-- Vários 'modulos' que são definidos por foreach/for, definindo cada tipo de introduzão de registos-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            @if ($edit == 1)
                                <h4 class="card-title">Atualizar um registo</h4>
                            @else
                                <h4 class="card-title">Inserir um registo</h4>
                                <?php $idselecionado = '' ?>
                            @endif
                        </div>
                        <div class="card-body">
                            <?php $contaclass = 1; ?>
                            <form wire:submit.prevent="submit">
                                @foreach ($registo as $a)

                                    @if($a['Type'] == 'text')
                                        <div class="form-group">
                                            <label>{{ $a['Field'] }}</label>
                                            <textarea class="form-control" cols="30" rows="10" wire:model="vartext.{{ $a['Field'] }}" required></textarea>
                                        </div>
                                    @endif

                                    @if ($a['Type'] == 'tinyint(4)')
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>{{ $a['Field'] }}</label>
                                                    <div class="form-control" style="font-size:3rem;height:60px;width:75%;">
                                                        <div class="row">

                                                            <div class="col-4" style="padding-top: 0px;">
                                                                <label>
                                                                    <input type="radio" name="choose{{ $contaclass }}" id="frown" value="1" wire:model="varchoose.{{ $a['Field'] }}">
                                                                    <svg viewBox="0 0 496 512" width="45" title="frown">
                                                                        <path id="frown-icon" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z" />
                                                                      </svg>
                                                                    <?php $contaclass++; ?>
                                                                </label>
                                                            </div>

                                                            <div class="col-4" style="padding-top: 0px;text-align: center;">
                                                                <label>
                                                                    <input type="radio" name="choose{{ $contaclass }}" id="meh" value="2" wire:model="varchoose.{{ $a['Field'] }}">
                                                                    <svg viewBox="0 0 496 512" width="45" title="meh">
                                                                        <path id="meh-icon" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm-80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm176 192H152c-21.2 0-21.2-32 0-32h192c21.2 0 21.2 32 0 32zm-16-128c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z" />
                                                                      </svg>
                                                                    <?php $contaclass++; ?>
                                                                </label>
                                                            </div>

                                                            <div class="col-4" style="padding-top: 0px;">
                                                                <label class="pull-right">
                                                                    <input type="radio" name="choose{{ $contaclass }}" id="smile" value="3" wire:model="varchoose.{{ $a['Field'] }}">
                                                                    <svg viewBox="0 0 496 512" width="45" title="smile">
                                                                        <path id="smile-icon" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm194.8 170.2C334.3 380.4 292.5 400 248 400s-86.3-19.6-114.8-53.8c-13.6-16.3 11-36.7 24.6-20.5 22.4 26.9 55.2 42.2 90.2 42.2s67.8-15.4 90.2-42.2c13.4-16.2 38.1 4.2 24.6 20.5z" />
                                                                      </svg>
                                                                    <?php $contaclass++; ?>
                                                                </label>
                                                            </div>

                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                                <div class="form-group">
                                    <label for="date">Data realizada</label>
                                    <input wire:model="datachoose" type="date" id="date" class="form-control" required>
                                </div>
                                <hr style="margin-bottom: 5px;">

                                <div class="form-group">
                                    <label for="fileUpload">Fotos (Opcional)</label>
                                    <div class="form-control" style="padding-top: 5px;">
                                        <div class="row">
                                            <div class="col-11" style="padding-top: 0px;">
                                                <input wire:model="fotos" style="height:auto" type="file" id="fileUpload" multiple>
                                            </div>
                                            @if (count($fotos) > 0)
                                                <div class="col-1" wire:click="cleanfiles">
                                                    <i class="nc-icon nc-icon nc-simple-remove"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="hi">Hora de ínicio (Opcional)</label>
                                            <input wire:model="hoin" id="hi" type="time" class="form-control">
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="hf">Hora de fim (Opcional)</label>
                                            <input wire:model="hofi" id="hf" type="time" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                @if ($erro != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $erro }}
                                    </div>
                                @endif
                                    <button wire:loading.attr="disabled" wire:target="fotos" class="btn btn-info btn-fill pull-right" type="submit">
                                        <i class="nc-icon nc-send" style="position: relative; top: 2px;"></i>
                                        Submeter
                                    </button>
                                    <div wire:loading wire:target="fotos" style="color: #4489d8; margin-right:10px;top: 3px;" class="la-ball-clip-rotate pull-right">
                                        <div></div>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-fill" wire:click="tabelas(0)">Mostrar todos os seus registos</button>
                </div>

                <!-- END -->

                <!-- Escolha dos clientes, universal para todos os tipos de registos-->

                <div class="col-lg-7" style="border-left:1px solid rgb(185, 185, 185);">
                    <div class="container" >
                        <div class="row">
                            <div class="col-5">
                                <div class="container vertical-scrollable" style="padding: 0px;">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title" style="font-weight:bold;"> Clientes selecionados: </h5>
                                        </div>
                                        <div class="card-body">
                                            <hr style="margin-top: 0px">
                                            @foreach ($selectedclients as $selected)
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-11" style="padding-right: 0px;">
                                                            <h5 class="card-title">{{ $selected['nome'].' '.$selected['apelido'] }}</h5>
                                                        </div>
                                                        <div class="col-1" wire:click="deSelectCliente('{{ $selected['id'] }}')" style="padding: 0px;display: flex;align-items: center;"><i class="nc-icon nc-icon nc-simple-remove"></i></div>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                            @if ($conta > 1)
                                                <button data-toggle="modal" data-target="#myModal1" class="btn btn-sm btn-info btn-fill pull-right">Agrupar clientes num grupo</button>
                                            @endif
                                            <div class="modal fade modal-mini modal-primary" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-height: 100px;max-width:500px">
                                                    <div class="modal-content">
                                                        <div class="modal-header justify-content-center">
                                                            <div class="container">
                                                                <h4 style="margin-bottom: 0px;">Utilizadores selecionados:</h4>
                                                                <div class="card-body table-full-width table-responsive">
                                                                    <table class="table table-image table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Foto</th>
                                                                                <th style="padding-left: 30px;padding-right: 30px;text-align: center !important;">Nome</th>
                                                                                <th>Apelido</th>
                                                                                <th>Data de entrada</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            @foreach ($selectedclients as $selected)
                                                                            <tr>
                                                                                <td>
                                                                                    @if($selected['foto'] == null)
                                                                                        <img class="w-100" src="{{ asset('light-dashboard/assets/img/default-avatar.png') }}"  alt="Não foi encontrada imagem">
                                                                                    @else
                                                                                        <img class="w-100" src="{{ asset('storage/'.$this->origem.'/fotos/'.$selected['foto']) }}" alt="{{ $selected['nome'] }}">
                                                                                    @endif
                                                                                </td>
                                                                                <td style="padding-left: 30px;padding-right: 30px;text-align: center;">{{ $selected['nome'] }}</td>
                                                                                <td>{{ $selected['apelido'] }}</td>
                                                                                <td style="display: table-cell;">{{ $selected['data_entrou'] }}</td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form wire:submit.prevent="gruposubmit">
                                                            <div class="modal-body text-center">
                                                                <div class="form-group">
                                                                    <h5 for="grupo">Nome do grupo:</h5>
                                                                    <input type="text" id="grupo" class="form-control" wire:model.defer="grupo">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" id="btnDismiss" class="btn btn-link btn-simple" data-dismiss="modal">Fechar</button>
                                                                <button type="submit" class="btn btn-info btn-fill">Guardar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire:ignore class="modal fade modal-mini modal-primary" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-height: 100px;max-width:500px">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center">
                                            <div class="modal-profile">
                                                <i class="nc-icon nc-simple-remove"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p>Tem a certeza que deseja eliminar este grupo?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btnDismiss2" class="btn btn-info btn-fill" data-dismiss="modal">Não</button>
                                            <button wire:click="RemoveGrupo" class="btn btn-danger btn-fill">Sim</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="container vertical-scrollable" style="padding: 0px; max-height:560px;">
                                    <div class="card" >
                                        @if ($gruposcolaborador->count() > 0)
                                            <div class="card-header">
                                                <h4 class="card-title">Escolha um dos seus grupos para efetuar um registo</h4>
                                                <hr style="margin-bottom: 0px;">
                                            </div>
                                            <div class="card-body" style="padding-top: 0px;">
                                                <div class="form-group">
                                                    <label>Pesquisar</label>
                                                    <input wire:model.debounce.250ms="pesquisaNomeGrupo" type="text" class="form-control" placeholder="Nome do grupo">
                                                </div>
                                                <hr>
                                                @foreach ($gruposcolaborador2 as $grucolab)

                                                    <div class="card card-user" style="margin-bottom: 0px;" >
                                                        <div wire:click="SelectCliente('{{ $grucolab->id }}',true)" class="card-image" style="height: 70px"><img src="#" alt=""></div>
                                                            <div wire:click="SelectCliente('{{ $grucolab->id }}',true)" class="card-body">
                                                                <div class="author" style="margin-top: -45px;">
                                                                    <div>
                                                                        <h5 class="title">{{ $grucolab->nome }}</h5>
                                                                    </div>
                                                                    <h5 class="title" style="margin-bottom: 0px;">Clientes no grupo:</h5>
                                                                </div>
                                                                <p class="description text-center">
                                                                    @foreach ($grucolab->Clientes as $client)
                                                                        {{ $client->nome.' '.$client->apelido }},
                                                                    @endforeach
                                                                </p>
                                                            </div>
                                                            <div wire:click="getremovegrupo('{{ $grucolab->id }}')" class="button-container ml-auto" style="padding-right: 5px;margin-bottom: 5px;">
                                                                <button style="padding:3px;padding-bottom: 0px;" data-toggle="modal" data-target="#myModal2" class="btn btn-fill btn-danger btn-icon">
                                                                    <i class="nc-icon nc-icon nc-simple-remove"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                @endforeach
                                                    </div>
                                        @endif
                                        <div class="card-header">
                                            <h4 class="card-title">Escolha os clientes para efetuar um registo</h4>
                                            <hr style="margin-bottom: 0px;">
                                        </div>
                                        <div class="card-body" style="padding-top: 0px;">
                                            <div class="form-group">
                                                <label>Pesquisar</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input wire:model.debounce.250ms="pesquisaNome" type="text" class="form-control" placeholder="Nome">
                                                    </div>
                                                    <div class="col">
                                                        <input wire:model.debounce.250ms="pesquisaApelido" type="text" class="form-control" placeholder="Apelido">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            @foreach ($clientes as $cliente)

                                                <div class="card card-user" style="margin-bottom: 0px;" wire:key="{{ $cliente->id }}" wire:click="SelectCliente('{{ $cliente->id }}', false)">
                                                    <div class="card-image" style="height: 70px">
                                                        <img src="#" alt="">
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="author">
                                                            <div>
                                                                @if($cliente->foto == null)
                                                                    <img class="avatar border-gray" src="{{ asset('light-dashboard/assets/img/default-avatar.png') }}"  alt="Não foi encontrada imagem">
                                                                @else
                                                                    <img class="avatar border-gray" src="{{ asset('storage/'.$this->origem.'/fotos/'.$cliente->foto) }}" alt="{{ $cliente->nome }}">
                                                                @endif
                                                                <h5 class="title">{{ $cliente->nome.' '.$cliente->apelido }}</h5>
                                                            </div>
                                                            <p class="description">

                                                            </p>
                                                        </div>
                                                        <p class="description text-center">
                                                            {{ $cliente->notas }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- END -->

            </div>
        </div>


        <?php
            if ($javas == 1)
            {
                echo '<script type="text/javascript">',
                    'showNotification("bottom","right");',
                    '</script>';
                $this->emit('refreshJS');
            }
            if ($javas == 2)
            {
                echo '<script type="text/javascript">',
                    'showNotificationErro("bottom","right");',
                    '</script>';
                $this->emit('refreshJS');
            }
            if($javas == 3)
            {
                echo '<script type="text/javascript">',
                    'showNotificationGrupo("bottom","right");',
                    '</script>';
                $this->emit('refreshJS');
            }
            if($javas == 4)
            {
                echo '<script type="text/javascript">',
                    'showNotificationRepGrupo("bottom","right");',
                    '</script>';
                $this->emit('refreshJS');
            }
            if ($javas == 5) {
                echo '<script type="text/javascript">',
                    'showNotificationRemGrupo("bottom","right");',
                    '</script>';
                $this->emit('refreshJS');
            }
            if ($javas == 7) {
                echo '<script type="text/javascript">',
                    'showNotificationUpReg("bottom","right");',
                    '</script>';
                $this->emit('refreshJS');
            }
        ?>



    </div>
    <!-- END -->
@elseif($show == 3)



<div>
    <div class="container-fluid" style="padding-left: 0px;">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Todos os ficheiros de {{ $titulo }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        @if($aviso == '')
                            @foreach ($objectos as $objecto)
                                <div class="col-4" style="padding-left: 0px">
                                    <div class="card" style="width: 19rem;">
                                        <?php
                                        $nomethumb3 = substr($objecto->link, -4, strpos($objecto->link, "."));
                                        $nomethumb = 'thumb_'.$objecto->link;
                                        if($nomethumb3 == '.pdf')
                                        {
                                            $nomethumb = substr($nomethumb, 0, strpos($nomethumb, "."));
                                            $nomethumb .= '.png';
                                        }
                                        ?>
                                        <img src="{{ asset('storage/'.$this->origem.'/thumbs/'.$nomethumb) }}" class="card-img-top" alt="{{ $objecto->nome_ficheiro }}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $objecto->nome_ficheiro }}</h4>
                                            <p class="card-text">{{ $objecto->descricao_ficheiro }}</p>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-6"><a download="{{ $objecto->nome_ficheiro }}" rel="noopener noreferrer" target="_blank" href="{{ asset('storage/'.$this->origem.'/ficheiros/'.$objecto->link) }}" class="btn btn-primary btn-fill">Transferir</a></div>
                                                    <div class="col-6" style="display: flex;justify-content: center;"><a target="_blank" data-title="{{ $objecto->nome_ficheiro }}" href="/storage/{{ $this->origem }}/ficheiros/{{ $objecto->link }}" class="btn btn-success btn-fill">Abrir</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning"  role="alert"> {{ $aviso }}. </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@elseif($show == 2)
    <div>
        <div wire:ignore class="modal fade modal-mini modal-primary" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-height: 100px;max-width:500px">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="modal-profile">
                            <i class="nc-icon nc-simple-remove"></i>
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <p>Tem a certeza que deseja eliminar este registo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDismiss3" class="btn btn-info btn-fill" data-dismiss="modal">Não</button>
                        <button wire:click="RemoveRegisto" class="btn btn-danger btn-fill">Sim</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card table-plain-bg">
                <div class="card-header">
                    <h4 class="card-title">Todos os seus registos</h4>
                </div>
                <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                @foreach ($registo as $a)
                                    @if ($a['Type'] == 'text')
                                        <th>{{ $a['Field'] }}</th>
                                    @endif
                                    @if ($a['Type'] == 'tinyint(4)')
                                        <th>{{ $a['Field'] }}</th>
                                    @endif
                                @endforeach
                                <th>Data realizada</th>
                                <th>Hora iniciada</th>
                                <th>Hora terminada</th>
                                <th style="width:200px;">Clientes</th>
                                <th>Criado às</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $it = 0; $ic = 0;
                            function record_sort($records, $field, $reverse=false)
                            {
                                $hash = array();

                                foreach($records as $record)
                                {
                                    $hash[$record[$field]] = $record;
                                }

                                ($reverse)? krsort($hash) : ksort($hash);

                                $records = array();

                                foreach($hash as $record)
                                {
                                    $records []= $record;
                                }

                                return $records;
                            }

                            $allclients = record_sort($allclients,"id");?>
                            @foreach ($allclients as $registo2)
                            <tr>
                                @foreach ($registo as $a)

                                    @if ($a['Type'] == 'text')
                                    <td class="text-center">
                                        {{ $vartext2[$it] }}
                                        <?php $it++; ?>
                                    </td>
                                    @endif
                                    @if ($a['Type'] == 'tinyint(4)')
                                    <td class="text-center">
                                        {{ $varchoose2[$ic] }}
                                        <?php $ic++; ?>
                                    </td>
                                    @endif

                                @endforeach
                                    <td>
                                        {{ $registo2['data_realizada'] }}
                                    </td>
                                    <td class="text-center">
                                        @if ($registo2['hora_iniciada'] == '')
                                            --:--
                                        @else
                                            {{ $registo2['hora_iniciada'] }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($registo2['hora_terminada'] == '')
                                            --:--
                                        @else
                                            {{ $registo2['hora_terminada'] }}
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Clientes -->
                                        @if (array_key_exists('cliente_id',$registo2))
                                            <?php $d = $clientesrecentes->where('id', $registo2['cliente_id'])->first();$indi = 1;?>
                                            {{ $d->nome.' '.$d->apelido }}
                                        @else
                                        <?php $indi = 0?>
                                        @foreach ($interrecentes as $rec)
                                            @if ($rec->id == $registo2['id'])
                                                <?php $e = $rec->Clientes()->get() ?>
                                                @foreach ($e as $f)
                                                    {{ $f->nome.' '.$f->apelido }},
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        {{ $registo2['created_at'] }}
                                    </td>
                                    <td>
                                        <button wire:click="Clone({{ $registo2['id'] }},{{ $indi }},'1')" class="btn btn-md btn-fill btn-warning">Editar</button>
                                    </td>
                                    <td style="display: table-cell;">
                                        <button wire:click="getremoveregisto({{ $registo2['id'] }},{{ $indi }})" data-toggle="modal" data-target="#myModal3" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php if ($javas == 6) {
            echo '<script type="text/javascript">',
                'showNotificationRemReg("bottom","right");',
                '</script>';
            $this->emit('refreshJS');
        }?>
    </div>

@elseif($show == 4)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($edit == 1)
                                <h4 class="card-title">Atualizar uma unidade</h4>
                            @else
                                <h4 class="card-title">Criar uma unidade</h4>
                            @endif

                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="unicreate">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="sigla">Sigla de identificação</label>
                                            <input wire:model.defer="sigla" type="text" class="form-control" id="sigla"
                                            @if ($fechar != '')
                                                {{ $fechar }}
                                            @else
                                                required
                                            @endif
                                            >
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomeuni">Nome da unidade</label>
                                            <input wire:model.defer="uninome" type="text" class="form-control" id="nomeuni" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nrtelemovel">Nº de telefone/telemóvel</label>
                                            <input wire:model.defer="nrtelemovel" type="text" class="form-control" id="nrtelemovel" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="emailuni">Email da unidade</label>
                                            <input wire:model.defer="uniemail" type="email" class="form-control" id="emailuni" required>
                                        </div>
                                    </div>
                                </div>
                                @if ($errouni != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errouni }}
                                    </div>
                                @endif
                                <button class="btn btn-info btn-fill pull-right" type="submit">
                                    <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
                                    Submeter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if ($todasunidades->count() > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card table-plain-bg">
                            <div class="card-header">
                                <h4 class="card-title">Todas as unidades criadas</h4>
                            </div>
                            <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sigla</th>
                                            <th>Nome da unidade</th>
                                            <th>Nº de telemóvel</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($todasunidades as $unidade)
                                        <tr>
                                            <td>
                                                {{ $unidade->id }}
                                            </td>
                                            <td>
                                                {{ $unidade->unidade }}
                                            </td>
                                            <td>
                                                {{ $unidade->nr_telefone }}
                                            </td>
                                            <td>
                                                {{ $unidade->email }}
                                            </td>
                                            <td style="text-align: center;">
                                                <button wire:click="Cloneuni('{{ $unidade->id }}')" class="btn btn-md btn-fill btn-warning">Editar</button>
                                            </td>
                                            <td style="text-align: center;display: table-cell;">
                                                <button wire:click="removeunidade('{{ $unidade->id }}')" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <?php if ($javas == 11)
        {
            echo '<script type="text/javascript">',
            'showNotificationUnidade("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 12)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemNoUnidade("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 13)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemUnidade("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 14)
        {
            echo '<script type="text/javascript">',
            'showNotificationUpUnidade("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        ?>
    </div>

@elseif($show == 5)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Criar um cargo</h4>
                                </div>
                                <div class="card-body">
                                    <form wire:submit.prevent="nivelsubmit">
                                        <div class="form-group">
                                            <label for="cargo">Cargo</label>
                                            <input class="form-control" type="text" id="cargo" wire:model="cargo" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input id="check1" class="form-check-input" type="checkbox" wire:model="podecli">
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10" style="padding-top: 9px;">
                                                <label for="check1">Pode criar clientes?</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input id="check2" class="form-check-input" type="checkbox" wire:model="podefich">
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10" style="padding-top: 9px;">
                                                <label for="check2">Pode introduzir ficheiros na página principal?</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input id="check3" class="form-check-input" type="checkbox" wire:model="podefamil">
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <label for="check3">Pode criar contas de familiares?</label>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input id="check4" class="form-check-input" type="checkbox" wire:model="check4">
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <label for="check4">Vai efetuar registos sobre clientes?</label>
                                            </div>
                                        </div>
                                        <hr>
                                        @if ($check4 == true)
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Quantos campos de texto?</label>
                                                        <input class="form-control" type="number" min="0" wire:model="texto">
                                                    </div>
                                                    @for ($i = 1;$i <= $texto; $i++)
                                                        <div class="form-group">
                                                            <label>Nome do campo</label>
                                                            <input class="form-control" type="text" min="0" wire:model="textarray.{{ $i }}" required>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="choose">Quantos campos de escolha múltipla?</label>
                                                        <input class="form-control" type="number" min="0" id="choose" wire:model="escolha">
                                                    </div>
                                                    @for ($i = 1;$i <= $escolha; $i++)
                                                        <div class="form-group">
                                                            <label>Nome do campo</label>
                                                            <input class="form-control" type="text" min="0" wire:model="escolharray.{{ $i }}" required>
                                                        </div>
                                                    @endfor
                                                </div>

                                            </div>

                                        @endif
                                        @if ($erronivel != '')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $erronivel }}
                                            </div>
                                        @endif
                                        <button class="btn btn-info btn-fill pull-right" type="submit">
                                            <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
                                            Submeter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="container vertical-scrollable" style="max-height:500px;">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Todos os cargos criados</h4>
                                    </div>
                                    <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cargo</th>
                                                    <th>Pode criar clientes?</th>
                                                    <th>Pode introduzir ficheiros na página principal?</th>
                                                    <th>Pode criar contas de familiares?</th>
                                                    <th style="display:table-cell;">Pode efetuar registos?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($todosniveis as $nivel)
                                                <tr>
                                                    <td>
                                                        {{ $nivel->nivel }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($nivel->clientes == 0)
                                                            Não
                                                        @else
                                                            Sim
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($nivel->ficheiros == 0)
                                                            Não
                                                        @else
                                                            Sim
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($nivel->familiares == 0)
                                                            Não
                                                        @else
                                                            Sim
                                                        @endif
                                                    </td>
                                                    <td style="display:table-cell;">
                                                        @if($nivelintervencao->where('niveis_id',$nivel->id)->count() < 1)
                                                            Não
                                                        @else
                                                            Sim
                                                        @endif
                                                    </td>
                                                    @if ($nivel->nivel == 'Admin')
                                                    @else
                                                    <td style="text-align: center;display: table-cell;">
                                                        <button wire:click="RemoveCargos({{ $nivel->id }})" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php if ($javas == 23)
        {
            echo '<script type="text/javascript">',
            'showNotificationNewNivel("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 24)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemNivelErro("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 25)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemNivel("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        ?>
    </div>

@elseif($show == 6)
    <div>
        <div wire:ignore class="modal fade modal-mini modal-primary" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-height: 100px;max-width:500px">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="modal-profile">
                            <i class="nc-icon nc-simple-remove"></i>
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <p>Tem a certeza que deseja eliminar esta conta de colaborador?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDismiss5" class="btn btn-info btn-fill" data-dismiss="modal">Não</button>
                        <button wire:click="colabremove" class="btn btn-danger btn-fill">Sim</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($edit == 1)
                                <h4 class="card-title">Atualizar uma conta de colaborador</h4>
                            @else
                                <h4 class="card-title">Criar uma conta de colaborador</h4>
                            @endif
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="colabsubmit">
                                <div class="form-group">
                                    <label for="emailcolab">Email do colaborador</label>
                                    <input class="form-control" type="email" id="emailcolab" wire:model.defer="emailcolab" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nomecolab">Nome</label>
                                            <input class="form-control" type="text" id="nomecolab" wire:model.defer="nomecolab" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="apelido">Apelido</label>
                                            <input class="form-control" type="text" id="apelido" wire:model.defer="apelidocolab" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passtemp">Password</label>
                                    <input class="form-control" type="text" id="passtemp" wire:model.defer="passtemp" required
                                    @if ($edit == 1)
                                        disabled
                                    @endif
                                    >
                                </div>
                                <?php $conta2 = 1; ?>
                                <div class="row">

                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="cargocolab">Cargo</label>
                                            <select class="form-control" id="cargocolab" wire:model.defer="cargocolab">
                                                <option value="">Carregue para abrir</option>
                                                @foreach ($todosniveis as $n)
                                                    <option value="{{ $n->id }}">{{ $n->nivel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label for="unidadecolab"><div class="row"><div class="col-3.5">Unidades</div><div class="col-8.5" style="padding-left: 0px;"><h6 style="top: 2px;position: relative;">(CTRL+Click para escolher vários)</h6></div></div></label>
                                            <select class="form-control" id="unidadecolab" wire:model.defer="unidadecolab" multiple>
                                                @foreach ($todosuni as $n)
                                                    <option value="{{ $n->id }}"
                                                        @if ($edit == 1)
                                                            @if ($paraeditar->unidades->contains($n->id))
                                                                selected
                                                            @endif
                                                        @endif
                                                    >{{ $n->unidade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if ($errocolab != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errocolab }}
                                    </div>
                                @endif
                                <button class="btn btn-info btn-fill pull-right" type="submit">
                                    <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
                                    Submeter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Todos as contas de colaboradores</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Cargo</th>
                                        <th>Unidades</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todoscolabs as $colab)
                                    <tr>
                                        <td>
                                            {{ $colab->nome.' '.$colab->apelido }}
                                        </td>
                                        <td>
                                            {{ $colab->email }}
                                        </td>
                                        <td>
                                            {{ $colab->Niveis->nivel }}
                                        </td>
                                        <td style="display:table-cell;">
                                            @foreach ($colab->unidades as $uni)
                                                {{ $uni->unidade }};
                                            @endforeach
                                        </td>
                                        @if ($colab->email == Auth::user()->email)
                                        @else
                                            <td style="text-align: center;">
                                                <button wire:click="clonecolab({{ $colab->id }})" class="btn btn-md btn-fill btn-warning">Editar</button>
                                            </td>
                                            <td style="text-align: center;display: table-cell;">
                                                <button wire:click="colabremoveget({{ $colab->id }})" data-toggle="modal" data-target="#myModal5" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($javas == 21)
        {
            echo '<script type="text/javascript">',
            'showNotificationColab("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 22)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemColab("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 23)
        {
            echo '<script type="text/javascript">',
            'showNotificationUpColab("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        ?>
    </div>
@elseif($show == 7)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($edit == 1)
                                <h4 class="card-title">Editar um cliente</h4>
                            @else
                                <h4 class="card-title">Criar um cliente</h4>
                            @endif

                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="submitcli">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomecli">Nome do cliente</label>
                                            <input class="form-control" type="text" id="nomecli" wire:model.defer="nomecli" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="apelidocli">Apelido do cliente</label>
                                            <input class="form-control" type="text" id="apelidocli" wire:model.defer="apelidocli" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="datacli">Data de entrada</label>
                                            <input class="form-control" type="date" id="datacli" wire:model.defer="datacli" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="notascli">Notas</label>
                                            <textarea class="form-control" rows="10" cols="30" id="notascli" wire:model.defer="notascli"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fileUpload3">Fotos (Opcional)</label>
                                            <div class="form-control" style="padding-top: 5px;">
                                                <div class="row">
                                                    <div class="col-11" style="padding-top: 0px;">
                                                        <input wire:model="fotocli" style="height:auto" type="file" id="fileUpload3" {{ $fechar }}>
                                                    </div>
                                                    @if ($fotocli != '')
                                                        <div class="col-1" wire:click="cleanfiles3">
                                                            <i class="nc-icon nc-icon nc-simple-remove"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="unicli">Unidades</label>
                                            <select class="form-control" id="unicli" wire:model.defer="unicli">
                                                <option value="" selected>Carregue para abrir</option>
                                                @foreach ($todosuni as $n)
                                                    <option value="{{ $n->id }}">{{ $n->unidade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="familcli"><div class="row"><div class="col-3.5" style="padding-left: 5px;">Familiares</div><div class="col-8.5" style="padding-left: 0px;"><h6 style="top: 2px;position: relative;">(CTRL+Click para escolher vários)</h6></div></div></label>
                                            <select class="form-control" id="familcli" wire:model.defer="familcli" multiple>
                                                @foreach ($todosfamils as $n)
                                                    <option value="{{ $n->id }}">{{ $n->nome.' '.$n->apelido }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if ($errorcli != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errorcli }}
                                    </div>
                                @endif
                                <button wire:loading.attr="disabled" wire:target="fotocli" class="btn btn-info btn-fill pull-right" type="submit">
                                    <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
                                    Submeter
                                </button>
                                <div wire:loading wire:target="fotocli" style="color: #4489d8; margin-right:10px;top: 3px;" class="la-ball-clip-rotate pull-right">
                                    <div></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Todos os clientes submetidos</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data de entrada</th>
                                        <th>Unidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todoscli as $e)
                                        <tr>
                                            <td>
                                                {{ $e->nome.' '.$e->apelido }}
                                            </td>
                                            <td>
                                                {{ $e->data_entrou }}
                                            </td>
                                            <td>
                                                {{ $e->unidades->unidade }}
                                            </td>
                                            <td style="text-align: center;">
                                                <button wire:click="clonecli('{{ $e->id }}')" class="btn btn-md btn-fill btn-warning">Editar</button>
                                            </td>
                                            <td style="text-align: center;display: table-cell;">
                                                <button wire:click="removecli('{{ $e->id }}')" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($javas == 51)
        {
            echo '<script type="text/javascript">',
            'showNotificationCli("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 52)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemCli("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        ?>
    </div>
@elseif($show == 8)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($edit == 1)
                                <h4 class="card-title">Editar um ficheiro</h4>
                            @else
                                <h4 class="card-title">Introduzir um ficheiro</h4>
                            @endif

                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="submitfich">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fileUpload2">Ficheiro</label>
                                            <div class="form-control" style="padding-top: 5px;">
                                                <div class="row">
                                                    <div class="col-11" style="padding-top: 0px;">
                                                        <input wire:model="ficheiros" style="height:auto;" type="file" id="fileUpload2" {{ $fechar }}>
                                                    </div>
                                                    @if ($ficheiros != '')
                                                        <div class="col-1" wire:click="cleanfiles2">
                                                            <i class="nc-icon nc-icon nc-simple-remove"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomefich">Nome do ficheiro</label>
                                            <input class="form-control" type="text" id="nomefich" wire:model.defer="nomefich" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="descfich">Descrição do ficheiro</label>
                                            <input class="form-control" type="text" id="descfich" wire:model.defer="descfich" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="unifich"><div class="row"><div class="col-3.5">Unidades</div><div class="col-8.5" style="padding-left: 0px;"><h6 style="top: 2px;position: relative;">(CTRL+Click para escolher vários)</h6></div></div></label>
                                            <select class="form-control" id="unifich" wire:model.defer="unifich" multiple required>
                                                @foreach ($todosuni as $n)
                                                    <option value="{{ $n->id }}">{{ $n->unidade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if ($errofich != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errofich }}
                                    </div>
                                @endif
                                <button wire:loading.attr="disabled" wire:target="ficheiros" class="btn btn-info btn-fill pull-right" type="submit">
                                    <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
                                    Submeter
                                </button>
                                <div wire:loading wire:target="ficheiros" style="color: #4489d8; margin-right:10px;top: 3px;" class="la-ball-clip-rotate pull-right">
                                    <div></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Todos os ficheiros submetidos</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome do ficheiro</th>
                                        <th>Descrição do ficheiro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fi as $e)
                                        <tr>
                                            <td>
                                                {{ $e['nome_ficheiro'] }}
                                            </td>
                                            <td>
                                                {{ $e['descricao_ficheiro'] }}
                                            </td>
                                            <td style="text-align: center;">
                                                <button wire:click="clonefich('{{ $e['id'] }}')" class="btn btn-md btn-fill btn-warning">Editar</button>
                                            </td>
                                            <td style="text-align: center;display: table-cell;">
                                                <button wire:click="removefich('{{ $e['id'] }}')" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($javas == 31)
        {
            echo '<script type="text/javascript">',
            'showNotificationFich("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 32)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemFich("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }?>
    </div>
@elseif($show == 9)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($edit == 1)
                                <h4 class="card-title">Editar uma conta de familiar</h4>
                            @else
                                <h4 class="card-title">Criar uma conta de familiar</h4>
                            @endif

                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="submitfamil">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomefamil">Nome do familiar</label>
                                            <input class="form-control" type="text" id="nomefamil" wire:model.defer="nomefamil" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="apelidofamil">Apelido do familiar</label>
                                            <input class="form-control" type="text" id="apelidofamil" wire:model.defer="apelidofamil" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="utilfamil">nome de utilizador</label>
                                            <input class="form-control" type="text" id="utilfamil" wire:model.defer="utilfamil" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="passfamil">password</label>
                                            <input class="form-control" type="text" id="passfamil" wire:model.defer="passfamil" required {{ $fechar }}>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nr_telfamil">Nº de telemóvel (opcional)</label>
                                    <input class="form-control" type="text" id="nr_telfamil" wire:model.defer="nr_telfamil">
                                </div>

                                @if ($errofamil != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errofamil }}
                                    </div>
                                @endif
                                <button class="btn btn-info btn-fill pull-right" type="submit">
                                    <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
                                    Submeter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Todos os familiares criados</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Nome de utilizador</th>
                                        <th>Nº de telemóvel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todosfamils as $e)
                                        <tr>
                                            <td>
                                                {{ $e->nome.' '.$e->apelido }}
                                            </td>
                                            <td>
                                                {{ $e->nome_utilizador }}
                                            </td>
                                            <td>
                                                {{ $e->nr_telefone }}
                                            </td>
                                            <td style="text-align: center;">
                                                <button wire:click="clonefamil('{{ $e->id }}')" class="btn btn-md btn-fill btn-warning">Editar</button>
                                            </td>
                                            <td style="text-align: center;display: table-cell;">
                                                <button wire:click="removefamil('{{ $e->id }}')" class="btn btn-md btn-fill btn-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($javas == 41)
        {
            echo '<script type="text/javascript">',
            'showNotificationFamil("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 42)
        {
            echo '<script type="text/javascript">',
            'showNotificationRemFamil("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }
        if ($javas == 43)
        {
            echo '<script type="text/javascript">',
            'showNotificationUpFamil("bottom","right");',
            '</script>';
            $this->emit('refreshJS');
        }?>
    </div>
@elseif($show == 10)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-user" style="margin-bottom: 0px;">
                        <div class="card-image" style="height: 70px">
                            <img src="#" alt="">
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <div>
                                    @if($clienteselect->foto == null)
                                        <img class="avatar border-gray" src="{{ asset('light-dashboard/assets/img/default-avatar.png') }}"  alt="Não foi encontrada imagem">
                                    @else
                                        <img class="avatar border-gray" src="{{ asset('storage/'.$this->origem.'/fotos/'.$clienteselect->foto) }}" alt="{{ $clienteselect->nome }}">
                                    @endif
                                    <h5 class="title">{{ $clienteselect->nome.' '.$clienteselect->apelido }}</h5>
                                </div>
                                <p class="description">
                                    Entrou em: {{ $clienteselect->data_entrou }} <br>
                                    Unidade a que pertence: {{ $clienteselect->unidades->unidade }}
                                </p>
                            </div>
                            <p class="description text-center">
                                {{ $clienteselect->notas }}
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Contactos de {{ $clienteuni->unidade }}</h4>
                        </div>
                        <div class="card-body">
                            <p>Email: {{ $clienteuni->email }}</p>
                            <p>Número de telefone: {{ $clienteuni->nr_telefone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="container vertical-scrollable" style="max-height:400px;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Atividades mais recentes de {{ $clienteselect->nome }}</h4>
                            </div>
                            <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                                @if ($erro3 != '')
                                    <div class="alert alert-warning" style="margin-right: 10px;" role="alert"> {{ $erro3 }} </div>
                                @else
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Realizada</th>
                                                <th>Registado por</th>
                                                <th>Realizado em</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($regrecente as $e)
                                                @if (array_key_exists('cliente_id',$e))
                                                    <tr>
                                                        <td>
                                                            Individualmente
                                                        </td>
                                                        <td>
                                                            {{ $colabclientes[$e['id']] }} ({{ $colabclientes[$colabclientes[$e['id']]] }})
                                                        </td>
                                                        <td>
                                                            {{ $e['data_realizada'] }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <button wire:click="VerMais('{{ $e['id'] }}','0')" class="btn btn-md btn-fill btn-info">Ver</button>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>
                                                            Em grupo
                                                        </td>
                                                        <td>
                                                            {{ $colabclientes[$e['id']] }} ({{ $colabclientes[$colabclientes[$e['id']]] }})
                                                        </td>
                                                        <td>
                                                            {{ $e['data_realizada'] }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <button wire:click="VerMais('{{ $e['id'] }}','1')" class="btn btn-md btn-fill btn-info">Ver</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        @if ($erro3 == '')
                            <button class="btn btn-primary btn-fill" style="float:right;margin-right:20px;margin-top:10px" wire:click="Vertudo({{ $clienteselect->id }})">Mostrar todas as atividades</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif($show == 11)
    <div>
        <?php $it = 0; $ic = 0; ?>
        <div class="container-fluid" style="padding-left: 0px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Atividade selecionada</h4>
                </div>
                <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Realizada</th>
                                <th>Realizado em</th>
                                <th>Iniciou a</th>
                                <th>Acabou a</th>
                                <th>Registado por</th>
                                <th>Registado em</th>
                                @foreach ($registo as $a)
                                    @if ($a->Type == 'text')
                                        <th>{{ $a->Field }}</th>
                                    @endif
                                    @if ($a->Type == 'tinyint(4)')
                                        <th>{{ $a->Field }}</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ $realizada }}
                                </td>
                                <td>
                                    {{ $registselect->data_realizada }}
                                </td>
                                <td>
                                    {{ $registselect->hora_iniciada }}
                                </td>
                                <td>
                                    {{ $registselect->hora_terminada }}
                                </td>
                                <td>
                                    {{ $colabclientes[$registselect['id']] }} ({{ $colabclientes[$colabclientes[$registselect['id']]] }})
                                </td>
                                <td>
                                    <?php date_default_timezone_set('Europe/Lisbon'); ?>{{ \Carbon\Carbon::parse($registselect->created_at)->diffForHumans() }}
                                </td>
                                @foreach ($registo as $a)

                                    @if ($a->Type == 'text')
                                    <td class="text-center" style="text-align: center;display: table-cell;">
                                        {{ $vartext2[$it] }}
                                        <?php $it++; ?>
                                    </td>
                                    @endif
                                    @if ($a->Type == 'tinyint(4)')
                                    <td class="text-center" style="text-align: center;display: table-cell;">
                                        <?php
                                        if($varchoose2[$ic] == 1) echo 'Mau';
                                        elseif($varchoose2[$ic] == 2) echo 'Mais ou Menos';
                                        elseif($varchoose2[$ic] == 3) echo 'Bom';
                                         $ic++; ?>
                                    </td>
                                    @endif

                                @endforeach
                                @if($btn == 'sim')
                                    <td style="text-align: center;">
                                        <button wire:click="verfotos('{{ $registselect->id }}','{{ $realizada }}')" class="btn btn-md btn-fill btn-info">Ver Fotos</button>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@elseif($show == 12)
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="container" >
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Todas as atividades de {{ $clienteselect->nome }}</h4>
                            </div>
                            <div class="card-body table-full-width table-responsive" style="margin-left: 0px;">
                                @if ($erro3 != '')
                                    <div class="alert alert-warning" style="margin-right: 10px;" role="alert"> {{ $erro3 }} </div>
                                @else
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Realizada</th>
                                                <th>Registado por</th>
                                                <th>Realizado em</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($regrecente as $e)
                                                @if (array_key_exists('cliente_id',$e))
                                                    <tr>
                                                        <td>
                                                            Individualmente
                                                        </td>
                                                        <td>
                                                            {{ $colabclientes[$e['id']] }} ({{ $colabclientes[$colabclientes[$e['id']]] }})
                                                        </td>
                                                        <td>
                                                            {{ $e['data_realizada'] }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <button wire:click="VerMais('{{ $e['id'] }}','0')" class="btn btn-md btn-fill btn-info">Ver</button>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>
                                                            Em grupo
                                                        </td>
                                                        <td>
                                                            {{ $colabclientes[$e['id']] }} ({{ $colabclientes[$colabclientes[$e['id']]] }})
                                                        </td>
                                                        <td>
                                                            {{ $e['data_realizada'] }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <button wire:click="VerMais('{{ $e['id'] }}','1')" class="btn btn-md btn-fill btn-info">Ver</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@elseif($show == 13)
    <div>
        <div class="container-fluid" style="padding-left: 0px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Fotos do dia {{ $registselect2->data_realizada }}</h4>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            @if($aviso == '')
                                @foreach ($mostrarfotos as $mostrarfoto)
                                    <div class="col-4" style="padding-left: 0px">
                                        <div class="card" style="width: 19rem;">
                                            <img src="{{ asset('storage/'.$origem.'/fotos/'.$mostrarfoto['link']) }}" class="card-img-top" alt="{{ $mostrarfoto['nome_foto'] }}">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning"  role="alert"> {{ $aviso }}. </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
