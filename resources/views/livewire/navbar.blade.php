
<div>



<nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class="container-fluid">
        <a class="navbar-brand" style="padding-right: 14px;">{{ $titulo }} </a>
        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="nav navbar-nav mr-auto">
                <!--
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <i class="nc-icon nc-palette"></i>
                        <span class="d-lg-none">Dashboard</span>
                    </a>
                </li>
                -->

                <!--
                <li class="dropdown nav-item">
                    <a href="" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="nc-icon nc-planet"></i>
                        <span class="notification">5</span>
                        <span class="d-lg-none">Notification</span>
                    </a>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item" href="#">Notification 1</a>
                        <a class="dropdown-item" href="#">Notification 2</a>
                        <a class="dropdown-item" href="#">Notification 3</a>
                        <a class="dropdown-item" href="#">Notification 4</a>
                        <a class="dropdown-item" href="#">Another notification</a>
                    </ul>
                </li>
                -->
                <!--
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nc-icon nc-zoom-split"></i>
                        <span class="d-lg-block">&nbsp;Search</span>
                    </a>
                </li>
                -->
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    @if ($unidade != '')
                        <a class="nav-link" href="/unidades">
                            <i class="nc-icon nc-refresh-02" style="margin-right: 10px;padding-bottom: 15px;"></i>
                            Mudar de unidade
                        </a>
                    @endif

                </li>
                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="no-icon">Dropdown</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </li>
                -->
                <li class="nav-item">
                    @if ($isadmin == 0)
                        <a class="nav-link" href="/mudarpasse">
                            <i class="nc-icon nc-key-25" style="margin-right: 10px;padding-bottom: 15px;"></i>
                            Mudar de palavra-passe
                        </a>
                    @endif
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/logout">
                        <i class="nc-icon nc-button-power" style="margin-right: 10px;padding-bottom: 15px;"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

</div>
<div class="content">
    <div class="container-fluid">
        <div class="section">
            @livewire('interior', ['unidade' => $unidade,'ab'=>$ab])
        </div>
    </div>
</div>

