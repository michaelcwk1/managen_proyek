<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Login')</title>
    <!-- Link ke CSS Nice Admin -->
    <link href="https://cdn.jsdelivr.net/npm/nice-admin@1.0.0/dist/css/styles.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Konten utama -->
    @yield('content')

    <!-- Link ke JS Nice Admin -->
    <script src="https://cdn.jsdelivr.net/npm/nice-admin@1.0.0/dist/js/scripts.min.js"></script>
</body>
</html>
