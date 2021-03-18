@if($show  == true)

<div>
    <h3>Ficheiros mais recentes:</h3>

    <!-- Pagina Principal-->
    @foreach ($objectos as $objecto)
        <br>
        <div class="card" style="width: 18rem;">
            <img src="{{ asset($origem . '/ficheiros/' . $objecto->link) }}" class="card-img-top" alt="{{ $objecto->nome_ficheiro }}">
            <div class="card-body">
                <h4 class="card-title">{{ $objecto->nome_ficheiro }}</h4>
                <p class="card-text">{{ $objecto->descricao_ficheiro }}</p>
                <a href="#" class="btn btn-primary">Transferir</a>
            </div>
        </div>
    @endforeach

</div>

@else

<div>
    <p><?php echo 'outros'; ?></p>
    <!-- Escolha dos clientes, universal para todos-->

    <!-- Vários 'modulos' que são definidos por foreach/for, definindo cada tipo introduzão de registos-->


</div>

@endif
