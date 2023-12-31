<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css" />

    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    @include('parts.backend.header')
    <div id="layoutSidenav">
        @include('parts.backend.sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @include('parts.backend.pagetitle')
                    @yield('content')
                </div>
            </main>
            @include('parts.backend.footer')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>

    <script>
        $('#lfm').filemanager('image');
    </script>


</body>
@yield('scripts')

@stack('js')
</html>
