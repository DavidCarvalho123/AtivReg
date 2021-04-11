<div>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" wire:submit.prevent="entrar">
                    <span class="login100-form-title p-b-26" style="font-size: 28px;">
                        Escolha a unidade para entrar
                    </span>
                    <span class="login100-form-title p-b-48" style="padding-bottom: 20px;">
                        <img style="width:120px;" src="{{ asset('img/logoAR.png') }}" alt="logo">
                    </span>
<br>
                    @if ($errors->any() == true)
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="font-size: 1rem; font-family:Poppins-Regular, sans-serif;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="wrap-input100">
                        <select class="input100 form-select" wire:model="selected" aria-label="Default select example">
                            <option value="" selected>Carregue para abrir</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->unidade }}</option>
                            @endforeach
                        </select>
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit">
                                Entrar
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-15">
						<a class="txt1" href="/">
							Voltar à pagina principal
                        </a>
					</div>

                </form>
            </div>
        </div>
    </div>
</div>
