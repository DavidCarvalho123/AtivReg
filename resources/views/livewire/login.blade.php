<div>
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
                                    <?php $counter = 0; ?>
                                    <li>{{ $error }}</li>
                                    @if ($error == 'Faltam campos para preencher.')
                                        <?php break; ?>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($counter == 1)
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php $counter = 0; ?>
                                <li>Credenciais inválidas</li>
                            </ul>
                        </div>
                    @endif
                    <!-- Email -->
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="email" name="email" id="email" placeholder="Email" wire:model.defer="form.email">
                        <span class="focus-input100"></span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <!-- Password -->
                    <div class="wrap-input100 validate-input">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password" id="password" placeholder="Password" wire:model.defer="form.password">
                        <span class="focus-input100"></span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    <br>



                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit">
                                Login
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
