<div>
    <div>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form class="login100-form validate-form" wire:submit.prevent="submitpalavra">

                        <span class="login100-form-title p-b-26">
                            Bem-vindo
                        </span>
                        <span class="login100-form-title p-b-48">
                            <img style="width:80px;" src="{{ asset('img/logoAR.png') }}" alt="logo">
                        </span>

                        @if ($error != '')
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    <li style="font-size: 1rem; font-family:Poppins-Regular, sans-serif;">{{ $error }}</li>
                                </ul>
                            </div>
                        @endif

                        <!-- Email -->
                        <div class="wrap-input100 validate-input">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="passwordantiga" id="passwordantiga" placeholder="Palavra-Passe Antiga" wire:model.defer="passwordantiga">
                            <span class="focus-input100"></span>
                        </div>


                        <!-- Password -->
                        <div class="wrap-input100 validate-input">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="passwordnova" id="passwordnova" placeholder="Palavra-Passe Nova" wire:model.defer="passwordnova">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="passwordnova2" id="passwordnova2" placeholder="Confirmar Palavra-Passe Nova" wire:model.defer="passwordnovaconfirm">
                            <span class="focus-input100"></span>
                        </div>
                        <br>



                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" type="submit">
                                    Alterar palavra-passe
                                </button>
                            </div>
                        </div>


                        <div class="text-center p-t-15">
                            <a class="txt1" href="/unidades">
                                Voltar ao painel de controlo
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
