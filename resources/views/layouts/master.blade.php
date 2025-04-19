<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SUT Portal')</title>
    <!-- Bootstrap CSS -->
    <link href="/bootstrap.min.css" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="brand-logo">
                        <img src="/logo.png" alt="Logo">
                    </div>
                    @include('layouts.menu')
                </div>
            </div>
            <div class="col-md-9 py-4">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="/bootstrap.bundle.min.js"></script>
</body>
</html>
