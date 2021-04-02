<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-dashboard/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('light-dashboard/assets/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name'), 'Laravel' }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!--    CSS Files    -->
    <link href="{{ asset('light-dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('light-dashboard/assets/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />
    <!--
    <link href="../assets/css/demo.css" rel="stylesheet" /> -->
    @livewireStyles

</head>
@if (session('a'))
    <?php $a = session('a');?>
@else
    <?php $a = ''; ?>
@endif
<body onLoad="checkRefresh();" onUnload="prepareForRefresh();">
    <div class="wrapper">

        @livewire('sidebar', ['unidade' => $a])
    </div>
    <?php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;
        if(Gate::allows('multiuni-only', Auth::user())) $multiuni = 'true';
        else $multiuni = 'false';
        ?>
</body>
    @livewireScripts



    <!--   Core JS Files   -->
    <script src="{{ asset('light-dashboard/assets/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-dashboard/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-dashboard/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('light-dashboard/assets/js/plugins/bootstrap-switch.js') }}"></script>
    <!--  Google Maps Plugin
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
    <!--  Chartist Plugin  -->
    <script src="{{ asset('light-dashboard/assets/js/plugins/chartist.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('light-dashboard/assets/js/plugins/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('light-dashboard/assets/js/light-bootstrap-dashboard.js?v=2.0.0') }} " type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script type="text/javascript">

        

        function showNotification(from, align)
        {

            color = Math.floor((Math.random() * 4) + 1);

            $.notify({
                icon: "nc-icon nc-bulb-63",
                message: "Registo criado com sucesso."

            },{
                type: 'primary',
                timer: 250,
                placement: {
                    from: from,
                    align: align
                }
            });
        }

        function showNotificationErro(from, align)
        {
            $('#btnDismiss').click();
            color = Math.floor((Math.random() * 4) + 1);

            $.notify({
                icon: "nc-icon nc-simple-remove",
                message: "O campo nome não pode estar vazio."

            },{
                type: 'danger',
                timer: 250,
                placement: {
                    from: from,
                    align: align
                }
            });
        }

        function showNotificationGrupo(from, align)
        {
            $('#btnDismiss').click();
            color = Math.floor((Math.random() * 4) + 1);

            $.notify({
                icon: "nc-icon nc-bulb-63",
                message: "O grupo foi criado com sucesso."

            },{
                type: 'primary',
                timer: 250,
                placement: {
                    from: from,
                    align: align
                }
            });
        }

        function showNotificationRepGrupo(from, align)
        {
            $('#btnDismiss').click();
            color = Math.floor((Math.random() * 4) + 1);

            $.notify({
                icon: "nc-icon nc-simple-remove",
                message: "Erro. Um grupo com esses clientes já existe."

            },{
                type: 'danger',
                timer: 250,
                placement: {
                    from: from,
                    align: align
                }
            });
        }

        function showNotificationRemGrupo(from, align)
        {
            $('#btnDismiss2').click();
            color = Math.floor((Math.random() * 4) + 1);

            $.notify({
                icon: "nc-icon nc-bulb-63",
                message: "O grupo foi eliminado com sucesso"

            },{
                type: 'primary',
                timer: 250,
                placement: {
                    from: from,
                    align: align
                }
            });
        }

        window.addEventListener('cleanfiles', event => {
            var file = document.getElementById("fileUpload");
            file.value = file.defaultValue;
        });



        var i = "<?php echo $multiuni; ?>";
        function checkRefresh()
            {
                if(i == "true")
                {
                    // Get the time now and convert to UTC seconds
                    var today = new Date();
                    var now = today.getUTCSeconds();
                    // Get the cookie
                    var cookie = document.cookie;
                    var cookieArray = cookie.split('; ');
                    // Parse the cookies: get the stored time
                    for(var loop=0; loop < cookieArray.length; loop++)
                    {
                        var nameValue = cookieArray[loop].split('=');
                        // Get the cookie time stamp
                        if( nameValue[0].toString() == 'SHTS' )
                        {
                            var cookieTime = parseInt( nameValue[1] );
                        }
                        // Get the cookie page
                        else if( nameValue[0].toString() == 'SHTSP' )
                        {
                            var cookieName = nameValue[1];
                        }
                    }
                    if( cookieName &&
                        cookieTime &&
                        cookieName == escape(location.href) &&
                        Math.abs(now - cookieTime) < 2 )
                    {
                        // Refresh detected

                        // Insert code here representing what to do on
                        // a refresh

                        // If you would like to toggle so this refresh code
                        // is executed on every OTHER refresh, then
                        // uncomment the following line
                        // refresh_prepare = 0;
                        // Simulate an HTTP redirect:
                        window.location.replace("/unidades");
                    }

                    // You may want to add code in an else here special
                    // for fresh page loads
                }
            }

            function prepareForRefresh()
            {
                if(i == 'true')
                {
                    if( refresh_prepare > 0 )
                    {
                        // Turn refresh detection on so that if this
                        // page gets quickly loaded, we know it's a refresh
                        var today = new Date();
                        var now = today.getUTCSeconds();
                        document.cookie = 'SHTS=' + now + ';';
                        document.cookie = 'SHTSP=' + escape(location.href) + ';';
                    }
                    else
                    {
                        // Refresh detection has been disabled
                        document.cookie = 'SHTS=;';
                        document.cookie = 'SHTSP=;';
                    }
                }
            }

            function disableRefreshDetection()
            {
                // The next page will look like a refresh but it actually
                // won't be, so turn refresh detection off.
                refresh_prepare = 0;

                // Also return true so this can be placed in onSubmits
                // without fear of any problems.
                return true;
            }

            // By default, turn refresh detection on
            var refresh_prepare = 1;


    </script>
</html>
