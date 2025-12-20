<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Camera Store')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/source/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('source/assets/css/notification.css') }}">
    @yield('custom_css')
</head>

<body class="{{ request()->routeIs('cart') ? 'cart-page' : '' }}">
    @include('header')
    @yield('content')
    @include('footer')
    <script src="{{ asset('source/assets/js/cart.js') }}"></script>
</body>

</html>