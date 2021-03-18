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
            <a href="" class="simple-text">
              <?php echo $db ?>
            </a>
        </div>

        <ul class="nav" id="myDIV">

            <li class="nav-item active" wire:click="PaginaPrincipal">
                <a class="nav-link" href="#" onclick="event.preventDefault();" >
                    <i class="nc-icon nc-icon nc-paper-2"></i>
                    <p>Página Principal</p>
                </a>
            </li>


            @foreach ($titulos as $titulo)
<br style="margin-top: 10px;">
            <li class="nav-item" wire:click="ViewNiveis">
                <a class="nav-link" href="#" onclick="event.preventDefault();" >
                    <i class="nc-icon nc-icon nc-paper-2"></i>
                    <p>{{ $titulo }}</p>
                </a>
            </li>

            @endforeach



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
    @livewire('navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="section">
                @livewire('interior')
            </div>
        </div>
    </div>
    @include('lightdashboardparts.footer')
</div>

<script>
    var header = document.getElementById("myDIV");
    var btns = header.getElementsByClassName("nav-item");
    var element = document.querySelector('.active');
    for (var i = 0; i < btns.length; i++)
     {
        btns[i].addEventListener("click", function()
        {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
</script>
