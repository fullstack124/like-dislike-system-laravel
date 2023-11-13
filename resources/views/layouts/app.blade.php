<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Like System</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-teal-400">
    <input type="hidden" name="" id="token" value="{{ csrf_token() }}">
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('post.js') }}"></script>
</body>

</html>
