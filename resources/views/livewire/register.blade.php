<div>
    <!--
    PLACEHOLDER
    Terá que se mudar para o formato final
    para verificar que é uma empresa real
-->
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" wire:submit.prevent="submit">

                <span class="login100-form-title p-b-26">
                    Bem-vindo
                </span>
                <span class="login100-form-title p-b-48">
                    <img style="width:80px;" src="{{ asset('img/logoAR.png') }}" alt="logo">
                </span>

                @if ($errors->any() == true)
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @if ($error == 'Faltam campos para preencher.')
                                    <?php break; ?>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($erroNr != '')
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <li>{{ $erroNr }}</li>
                    </ul>
                </div>
                @endif
                <!-- Name -->
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="name" id="name" placeholder="Nome" wire:model.defer="form.name">
                    <span class="focus-input100"></span>
                </div>


                <!-- Email -->
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="email" name="email" id="email" placeholder="Email" wire:model.defer="form.email">
                    <span class="focus-input100"></span>
                </div>


                <!-- Password -->
                <div class="wrap-input100 validate-input">
                    <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input class="input100" type="password" name="password" id="password" placeholder="Senha" wire:model.defer="form.password">
                    <span class="focus-input100"></span>

                </div>

                <!-- Confirm Password -->
                <div class="wrap-input100 validate-input">
                    <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input class="input100" type="password" name="password_confirmation" id="password-confirm" placeholder="Confirmar Senha" wire:model.defer="form.password_confimation">
                    <span class="focus-input100"></span>
                </div>

            <hr>

                <!-- DB -->
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="DB" id="DB" placeholder="Nome da Organização" wire:model.defer="db">
                    <span class="focus-input100"></span>
                </div>

                <!-- Nº Contribuinte -->
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="Contribuinte" id="Contribuinte" placeholder="Nº Contribuinte" wire:model.defer="Ncontribuinte">
                    <span class="focus-input100"></span>
                </div>
<br>



                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" type="submit">
                            Registar
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




<!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->
</div>
