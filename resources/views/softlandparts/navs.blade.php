<!-- ======= Mobile Menu ======= -->
<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div>
        <ul class="site-nav-wrap">
            <li class="active"><a href="index.html" class="nav-link">Home</a></li>
            <li><a href="features.html" class="nav-link">Features</a></li>
            <li><a href="pricing.html" class="nav-link">Pricing</a></li>

            <li class="has-children"><span class="arrow-collapse collapsed" data-toggle="collapse" data-target="#collapseItem0" aria-expanded="false"></span>
                <a href="blog.html" class="nav-link">Blog</a>
                <ul class="collapse" id="collapseItem0" style="">
                    <li><a href="blog.html" class="nav-link">Blog</a></li>
                    <li><a href="blog-single.html" class="nav-link">Blog Sigle</a></li>
                </ul>
            </li>
            <li><a href="contact.html" class="nav-link">Contact</a></li>
        </ul>
    </div>
</div>

<!-- ======= Header ======= -->
<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

    <div class="container">
        <div class="row align-items-center">

            <div class="col-6 col-lg-2">
                <h1 class="mb-0 site-logo text-center"><a href="/">AtivReg</a></h1>

            </div>

            <div class="col-12 col-md-10 d-none d-lg-block">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <nav class="site-navigation position-relative text-left" role="navigation">
                                <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block" style="padding-left:0px">
                                    <li><a href="/docs" class="nav-link">Documentação</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col">
                            <nav class="site-navigation position-relative text-right" role="navigation">

                                <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                    @guest
                                        <li><a href="/Login" class="nav-link">Login</a></li>
                                        <li><a href="/Register" class="nav-link">Registar</a></li>
                                    @endguest
                                    @auth
                                        <li><a href="/logout" class="nav-link">Logout</a></li>
                                    @endauth

                                    <!--
                                    <li><a href="features.html" class="nav-link">Features</a></li>
                                    <li><a href="pricing.html" class="nav-link">Pricing</a></li>

                                    <li class="has-children">
                                        <a href="blog.html" class="nav-link">Blog</a>
                                        <ul class="dropdown">
                                            <li><a href="blog.html" class="nav-link">Blog</a></li>
                                            <li><a href="blog-single.html" class="nav-link">Blog Sigle</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="contact.html" class="nav-link">Contact</a></li>
                                -->

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-6 d-inline-block d-lg-none ml-md-0 py-3" style="position: relative; top: 3px;">
                <a href="#" class="burger site-menu-toggle js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                    <span></span>
                </a>
            </div>

        </div>
    </div>

</header>
