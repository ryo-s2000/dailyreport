<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>日報作成ツール</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/03da6a0c32.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <meta name=”viewport” content=”width=device-width, initial-scale=1”>

    <!-- Loading Bootstrap -->
    <link href="../../dist/css/vendor/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="../../dist/css/flat-ui.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../dist/favicon.ico">

</head>
<body>
    <div id="app">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

        <!-- Bootstrap 4 requires Popper.js -->
        <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>

        <!-- Loading floatThead -->
        <script src="../../dist/scripts/jquery.floatThead.min.js"></script>

        <!-- Loading Flat UI -->
        <script src="../../dist/scripts/flat-ui.js"></script>
        <script src="../assets/js/application.js"></script>

        <script>
            $(document).ready(function(){
            $('select[name="inverse-dropdown"], select[name="inverse-dropdown-optgroup"], select[name="inverse-dropdown-disabled"]').select2({dropdownCssClass: 'select-inverse-dropdown'});

            $('select[name="searchfield"]').select2({dropdownCssClass: 'show-select-search'});
            $('select[name="inverse-dropdown-searchfield"]').select2({dropdownCssClass: 'select-inverse-dropdown show-select-search'});
            });
        </script>

        <div class="col-md-12 col-xs-5">
            <h1><a href="/">日報作成ツールPreβ</a></h1>
        </div>

        <main class="py-4">
            @yield('content')
        </main>

    </div>
</body>
</html>
