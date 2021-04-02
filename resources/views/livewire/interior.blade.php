

@if($show  == 1)
    <div>
    <!-- Pagina Principal -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Ficheiros mais recentes:</h3>
                    <br>
                    <div class="container">
                        <div class="row">
                            @if($aviso == '')
                                @foreach ($objectos as $objecto)
                                    <div class="col" style="padding-left: 0px">
                                        <div class="card" style="width: 19rem;">
                                            <img src="{{ asset('storage/'.$this->origem.'/ficheiros/'.$objecto->link) }}" class="card-img-top" alt="{{ $objecto->nome_ficheiro }}">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $objecto->nome_ficheiro }}</h4>
                                                <p class="card-text">{{ $objecto->descricao_ficheiro }}</p>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-6"><a href="#" class="btn btn-primary">Transferir</a></div>
                                                        <div class="col-6" style="display: flex;justify-content: center;"><a href="#" class="btn btn-success">Abrir</a></div>
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
                    @if($aviso == '')
                        <button class="btn btn-primary btn-fill" wire:click="tabelas(1)">Mostrar todos os ficheiros da unidade</button>
                    @endif
                </div>

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
                    @foreach ($regrecente as $recente)
                        <?php $d = 't' ?>
                        @if(array_key_exists('cliente_id',$recente))
                            <?php $d = $clientesrecentes->where('id', $recente['cliente_id'])->first();?>
                        @else
                            @foreach ($interrecentes as $rec)
                                @if($rec->id == $recente['id'])
                                <?php $e = $rec->Clientes()->where('unidades_id','=',$unidade)->get();?>
                                    @if($e->count() < 1)
                                        <?php $d = null; ?>
                                    @endif
                                @endif
                            @endforeach
                        @endif

                            @if ($d != null)

                                <div class="card">
                                    <div class="card-header">
                                        @if(array_key_exists('cliente_id',$recente))

                                            <h5 class="title" style="margin-bottom: 0px;">Cliente: {{ $d->nome.' '.$d->apelido }}</h5>
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
                                                <p class="description">{{ \Carbon\Carbon::parse($recente['created_at'])->diffForHumans(['parts' => 2, 'join' => true]) }}</p>
                                            </div>
                                            <div class="col-4">
                                                @if (array_key_exists('cliente_id',$recente))
                                                    <?php $indi = 1; ?>
                                                @else
                                                    <?php $indi = 0; ?>
                                                @endif
                                                <div wire:click="Clone('{{ $recente['id'] }}', {{ $indi }})" class="button-container" style="padding-right: 5px;margin-bottom: 5px;">
                                                    <button style="padding-left: 8px;padding-right: 8px;" class="btn btn-warning btn-fill pull-right" type="submit">
                                                        <i class="nc-icon nc-single-copy-04" style="position: relative;top: 2px;"></i>
                                                        Clonar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @else
                                <?php  $contaaviso++; ?>
                                @if ($contaaviso == 1)
                                    <?php $aviso2 = 'Ainda não criou nenhum registo nesta unidade'; ?>
                                    <div class="alert alert-warning" role="alert"> {{ $aviso2 }}. </div>
                                @endif
                            @endif
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert"> {{ $aviso2 }}. </div>
                @endif
                @if($aviso2 == '')
                    <button class="btn btn-primary btn-fill" wire:click="tabelas(0)">Mostrar todos os seus registos</button>
                @endif
                </div>

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
                            <h4 class="card-title">Inserir um registo</h4>
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
                                        <i class="nc-icon nc-send" style="position: relative;top: 2px;"></i>
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
                                                                                        <img class="w-100" src="{{ asset('storage/'.$this->origem.'/'.$this->unidade.'/fotos/'.$selected['foto']) }}" alt="{{ $selected['nome'] }}">
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
                                <div class="container vertical-scrollable" style="padding: 0px; max-height:640px;">
                                    <div class="card" >
                                        @if ($gruposcolaborador->count() > 0)
                                            <div class="card-header">
                                                <h4 class="card-title">Escolha um dos seus grupos para evetuar um registo</h4>
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
                                            <h4 class="card-title">Escolha os clientes para evetuar um registo</h4>
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
                                                                    <img class="avatar border-gray" src="{{ asset('storage/'.$this->origem.'/'.$this->unidade.'/fotos/'.$cliente->foto) }}" alt="{{ $cliente->nome }}">
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
        ?>



    </div>
    <!-- END -->
@elseif($show == 3)
<div>

</div>
@elseif($show == 2)
    <div>
        <div class="col-md-12">
            <div class="card table-plain-bg">
                <div class="card-header">
                    <h4 class="card-title">Todos os seus registos</h4>
                </div>
                <div class="card-body table-full-width table-responsive">
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
                                <th>Clientes</th>
                                <th>Criado a</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $it = 0; $ic = 0;?>
                            @foreach ($allclients as $registo)
                            <tr>
                                <td>
                                    @foreach ($registo as $a)
                                        @if ($a['Type'] == 'text')
                                            {{ $vartext[$it] }}
                                            <?php $it++; ?>
                                            @endif
                                        @if ($a['Type'] == 'tinyint(4)')
                                            {{ $varchoose[$ic] }}
                                            <?php $ic++; ?>
                                            @endif
                                    @endforeach
                                </td>

                                    <td>
                                        {{ $registo['data_realizada'] }}
                                    </td>
                                    <td>
                                        {{ $registo['hora_iniciada'] }}
                                    </td>
                                    <td>
                                        {{ $registo['hora_terminada'] }}
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        {{ $registo['created_at'] }}
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


