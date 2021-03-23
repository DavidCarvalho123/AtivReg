
@if ($unidadeescolhida == '')

@else


    @if($show  == true)
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
                                            <img src="{{ asset('ficheiros/' . $origem . '/' . $objecto->link) }}" class="card-img-top" alt="{{ $objecto->nome_ficheiro }}">
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
                                <div class="alert alert-warning"  role="alert"> {{ $aviso }} </div>
                            @endif
                        </div>
                    </div>
                    @if($aviso == '')
                        <a href="#">Abrir mais antigos...</a>
                    @endif
                </div>

                <div class="col-lg-4">
                    <h3>Registos mais recentes:</h3>
                    <br>
                    <h3>teste</h3>
                </div>
            </div>
        </div>

    </div>
    <!-- END -->

    @else

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
                            <form wire:submit.prevent="submit">
                                @if ($contatext > 0)
                                <div class="form-group">
                                    <label>Texto</label>
                                    <input type="text" class="form-control" placeholder="Username">
                                </div>
                                @endif
                                @if ($contaimg > 0)
                                <div class="form-group">
                                    <label>imagens</label>
                                    <input type="text" class="form-control" placeholder="escolhas">
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
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
                                                            <h5 class="card-title">{{ $selected->nome.' '.$selected->apelido }}</h5>
                                                        </div>
                                                        <div class="col-1" wire:click="SelectCliente('{{ $selected->id }}')" style="padding: 0px;display: flex;align-items: center;"><i class="nc-icon nc-icon nc-simple-remove"></i></div>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="container vertical-scrollable" style="padding: 0px;">
                                    <div class="card" >
                                        <div class="card-header">
                                            <h4 class="card-title">Escolha os clientes para evetuar um registo</h4>
                                            <hr style="margin-bottom: 0px;">
                                        </div>
                                        <div class="card-body" style="padding-top: 0px;">
                                            <div class="form-group">
                                                <label>Pesquisar</label>
                                                <input wire:model="pesquisa" type="text" class="form-control" placeholder="Introduza aqui texto...">
                                            </div>
                                            <hr>
                                            @foreach ($clientes as $cliente)

                                                <div class="card card-user" style="margin-bottom: 0px;" wire:click="SelectCliente('{{ $cliente->id }}')">
                                                    <div class="card-image" style="height: 70px"><img src="#" alt=""></div>
                                                        <div class="card-body">
                                                            <div class="author">
                                                                <div>
                                                                    @if($cliente->foto == null)
                                                                        <img class="avatar border-gray" src="{{ asset('light-dashboard/assets/img/default-avatar.png') }}"  alt="Não foi encontrada imagem">
                                                                    @else
                                                                        <img class="avatar border-gray" src="{{ asset('fotos/' . $origem . '/' . $cliente->foto) }}" alt="{{ $cliente->nome }}">
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






    </div>
    <!-- END -->
    @endif

@endif


