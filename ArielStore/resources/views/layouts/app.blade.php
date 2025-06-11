<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ariel Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- Header luôn nằm trên cùng, full width --}}
    @include('layouts.header')

    {{-- Bố cục nội dung gồm sidebar + content --}}
    <div class="d-flex">
        {{-- Sidebar bên trái --}}
        @include('layouts.sidebar')

        {{-- Nội dung chính --}}
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

</body>
</html>
