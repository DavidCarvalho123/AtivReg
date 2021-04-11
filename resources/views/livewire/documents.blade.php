<div>
    <section class="hero-section inner-page">
        <div class="wave">

            <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                        <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z" id="Path"></path>
                    </g>
                </g>
            </svg>

        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-7 text-center hero-text">
                            <h1>Informações sobre o AtivReg</h1>
                            <h6 style="color: #fff">Escolha uma das secções presentes em baixo:</h6>
                            <br>

                            <button type="button" class="btn btn-primary" wire:click="click1"><span>Administradores</span></button>
                            <button type="button" class="btn btn-primary" wire:click="click2"><span>Colaboradores</span></button>
                            <button type="button" class="btn btn-primary" wire:click="click3"><span>Familiares</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@if($mostra == 0)
<br><br><br><br><br>
@elseif($mostra == 1)

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <h1 class="text-center">Administradores</h1>
            </div>
        </div>
    </div>

    <section class="section pb-0">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-7 ml-auto order-2">
                <h2 class="mb-4">Registar na aplicação</h2>
                <p class="mb-4">Esta página é onde vai criar a sua instituição e a conta de <b>Administrador</b>, terá de disponibilizar o nome da instituição bem como o número de contribuinte, depois de introduzir os dados todos terá de fazer login com o email e a senha que acabou de introduzir e irá lhe ser atribuido o cargo de <b>Administrador</b></p>
            </div>
            <div class="col-md-3">
                <img src="{{ asset('img/Screenshot_10.png') }}" alt="Image" style="height: 500px" class="img-fluid">
            </div>
          </div>
        </div>
      </section>

    <section class="section pb-0" style="padding-top: 5rem;">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-4 mr-auto">
              <h2 class="mb-4">Unidades</h2>
              <p class="mb-4">Esta página é onde pode introduzir as unidades da sua empresa, ou seja, se a sua empresa tiver um estabelecimento em Entrecampos e no Parque das Nações, como definido na figura ao lado, deve inseri-los aqui.</p>
            </div>
            <div class="col-md-6">
              <img src="{{ asset('img/Screenshot_5.png') }}" alt="Image" class="img-fluid">
            </div>
          </div>
        </div>
      </section>

    <section class="section pb-0">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-4 ml-auto order-2">
                <h2 class="mb-4">Cargos</h2>
                <p class="mb-4">Esta página é onde pode criar cada cargo da sua empresa, onde pode também definir quais e quantos campos um colaborador com este cargo poderá introduzir e se pode fazer certos registos, como inserir clientes, criar contas de familiares e inserir ficheiros.</p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('img/Screenshot_8.png') }}" alt="Image" class="img-fluid">
            </div>
          </div>
        </div>
      </section>


    <section class="section pb-0">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-4 mr-auto">
              <h2 class="mb-4">Colaboradores</h2>
              <p class="mb-4">Esta página é onde pode criar contas para os seus colaboradores, onde deve definir qual o cargo deles e qual as unidades em que eles estão efetivos.</p>
            </div>
            <div class="col-md-6">
              <img src="{{ asset('img/Screenshot_7.png') }}" alt="Image" class="img-fluid">
            </div>
          </div>
        </div>
      </section>
@elseif($mostra == 2)

<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <h1 class="text-center">Colaboradores</h1>
        </div>
    </div>
</div>

<section class="section pb-0">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 ml-auto order-2">
            <h2 class="mb-4">Página Principal</h2>
            <p class="mb-4">Esta página é onde pode ver os ficheiros mais recentes que foram inseridos na unidade e os seus registos mais recentes com a opção de poder copiar este registo para poder efetuar um registo igual ou semelhante.</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/Screenshot_16.png') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="section pb-0">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 mr-auto">
            <h2 class="mb-4">Como Inserir registos</h2>
            <p class="mb-4">Para inserir um registo basta entrar na página cujo nome é o seu cargo da empresa, aí vai ter de carregar nas imagens dos clientes que quiser para efetuar o registo e depois tem de preencher os campos com os dados que precisar.<br>Se não tiver esta opção e achar que precise dela, fale com um técnico de informática ou quem registou a sua instituição nesta plataforma.</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/Screenshot_17.png') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="section pb-0">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5 ml-auto order-2">
            <h2 class="mb-4">Como inserir e alterar ficheiros</h2>
            <p class="mb-4">Para inserir e alterar um ficheiro basta entrar na página chamada ficheiros e inserir os campos com os dados que quiser e definir para quais unidades é que esse ficheiro irá ser mostrado, este será apenas disponibilizado para colaboradores.<br>Se não tiver esta opção e achar que precise dela, fale com um técnico de informática ou quem registou a sua instituição nesta plataforma.</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/Screenshot_19.png') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="section pb-0">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 mr-auto">
            <h2 class="mb-4">Como criar e alterar contas para familiares</h2>
            <p class="mb-4">Para criar e alterar uma conta de acesso para familiares basta ir para a página chamada familiares e introduzir os dados corretos do familiar que estiver a adicionar. A palavra passe deve ser algo seguro mas ainda assim terá uma opção para mudar de palavra-passe quando quiser.<br>Se não tiver esta opção e achar que precise dela, fale com um técnico de informática ou quem registou a sua instituição nesta plataforma.</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/Screenshot_20.png') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="section pb-0">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5 ml-auto order-2">
            <h2 class="mb-4">Como inserir novos clientes e alterar clientes existentes</h2>
            <p class="mb-4">Para inserir e alterar clientes basta ir para a página clientes onde vai pode alterar informações sobre clientes já existentes ou criar novos, especificando qual a unidade em que ele está e quais os familiares que terão acesso às informações do mesmo.<br>Se não tiver esta opção e achar que precise dela, fale com um técnico de informática ou quem registou a sua instituição nesta plataforma.</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/Screenshot_28.png') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

@elseif($mostra == 3)

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <h1 class="text-center">Familiares</h1>
            </div>
        </div>
    </div>

    <section class="section pb-0">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-4 ml-auto order-2">
                <h2 class="mb-4">Página com os meus familiares</h2>
                <p class="mb-4">As únicas páginas que terá acesso são as que têm cada um dos seus familiares. À esquerda poderá escolher qual familiar é que quer visualizar e à direita poderá ver as atividades mais recentes dessa pessoa.<br>Se carreguar no Ver poderá visualizar mais informações da atividade bem como fotos que possivelmente foram anexadas com o registo.</p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('img/Screenshot_29.png') }}" alt="Image" class="img-fluid">
            </div>
          </div>
        </div>
      </section>
@endif
</div
