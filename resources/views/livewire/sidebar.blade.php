



    <div class="sidebar" data-color="blue"  wire:init="loadPaginaPrincipal">
        <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
        -->

        <!--

            Instalar LiveWire, a maioria da mágia do programa acontecerá aqui
            dependendo do nivel de permissão que o utilizador que estiver logado terá, haverá
            uma função aqui que determinará quantos botões apareceram (ex: se o utilizador tiver
            um nivel de 'animadora', apenas lhe aparecerá o botão de animadora, se alguem tiver
            um nivel que lhe disponibilize usar duas tabelas, aparecera esses dois botões (os botões
            estarão diretamente ligados com as tabelas das intervenções)) estes botões vão mandar o
            utilizador para a mesma página e dependendo em qual carregou aparece os campos necessários
            para preencher uma intervenção

        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                <?php echo $db ?>
                </a>
            </div>




                <ul class="nav" id="myDIV">
                    @if ($admin == 0)
                        <li class="nav-item {{ $pagpri }}" wire:click="PaginaPrincipal">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-paper-2"></i>
                                <p>Página Principal</p>
                            </a>
                        </li>
                        @foreach ($titulos as $titulo)
                            <br style="margin-top: 10px;">
                            <li class="nav-item {{ $viewnivel }}" wire:click="ViewNiveis('{{ $titulo }}')">
                                <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                    <i class="nc-icon nc-icon nc-notes"></i>
                                    <p>{{ $titulo }}</p>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="nav-item {{ $uni }}" wire:click="ClickUnidades">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-app"></i>
                                <p>Unidades</p>
                            </a>
                        </li>
                        <br style="margin-top: 10px;">
                        <li class="nav-item {{ $nive }}" wire:click="ClickNiveis">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-paper-2"></i>
                                <p>Cargos</p>
                            </a>
                        </li>
                        <br style="margin-top: 10px;">
                        <li class="nav-item {{ $colab }}" wire:click="ClickColab">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-badge"></i>
                                <p>Colaboradores</p>
                            </a>
                        </li>
                    @endif
                    @if ($other2 == 1)
                        <br style="margin-top: 10px;">
                        <li class="nav-item {{ $otherclick2 }}" wire:click="Clickother2">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-single-copy-04"></i>
                                <p>Ficheiros</p>
                            </a>
                        </li>
                    @endif
                    @if ($other3 == 1)
                        <br style="margin-top: 10px;">
                        <li class="nav-item {{ $otherclick3 }}" wire:click="Clickother3">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-circle-09"></i>
                                <p>Familiares</p>
                            </a>
                        </li>
                    @endif
                    @if ($other1 == 1)
                        <br style="margin-top: 10px;">
                        <li class="nav-item {{ $otherclick1 }}" wire:click="Clickother1">
                            <a class="nav-link" href="#" onclick="event.preventDefault();" >
                                <i class="nc-icon nc-icon nc-badge"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                    @endif


                <!--
                <li>
                    <a class="nav-link" href="#">
                        <i class="nc-icon nc-bell-55"></i>
                        <p>Second example</p>
                    </a>
                </li>
                -->


            </ul>

        </div>
    </div>


    <div class="main-panel">
        @livewire('navbar', ['unidade' => $unidade])
        @livewire('footer')
    </div>



