<!DOCTYPE html>
<html lang="es" class="light">

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de ventas web touchscreen para restaurantes y negocios de comida rápida">
    <meta name="keywords" content="ventas,sistema,web,envío,comida,restaurante,ordenes,express,pantalla,táctil">
    <meta name="author" content="luisfax.com">

    <title>Sistema de Venta Rápida - fastFOOD</title>

    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/snackbar.min.css') }}" />
    <script src="{{ asset('js/kioskboard-aio-2.0.0.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/mc-calendar.min.css') }}">
    <script src="{{ asset('js/mc-calendar.min.js') }}"></script>

     <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}" />
    <script src="{{ asset('js/apexcharts.js') }}"></script>


    <style>
        .image-fit>img {
            object-fit: contain !important;
        }

        nav p {
            display: none !important;
        }
    </style>

    <livewire:styles />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="main">
    <!-- BEGIN: Mobile Menu -->
    @include('layouts.theme.mobile-menu')
    <!-- END: Mobile Menu -->
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        @include('layouts.theme.sidebar')
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <!-- BEGIN: Top Bar -->
            @include('layouts.theme.topbar')
            <!-- END: Top Bar 

            <div class="grid grid-cols-12">
                -->
            {{ $slot }}


        </div>
        <!-- END: Content -->
    </div>

    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="{{ asset('js/snackbar.min.js')}}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/alpine.js') }}" defer></script>



    <script>
        window.addEventListener('noty', event => {
            Snackbar.show({
                text: event.detail.msg,
                actionText: 'CERRAR',
                actionTextColor: '#fff',
                backgroundColor: event.detail.type == 'success' ? '#2187EC' : '#e7515a',
                pos: 'top-right'
            });
        })

        function destroy(componentName, methodName = 'destroy', rowId) {
            swal({
                title: '¿Confirmas eliminar el registro?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                confirmButtonColor: '#e7515a',
                cancelButtonText: 'Cerrar',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emitTo(componentName, methodName, rowId)
                    swal.close()
                }
            })
        }
    </script>

    <livewire:scripts />
    <!-- END: JS Assets-->
</body>

</html>