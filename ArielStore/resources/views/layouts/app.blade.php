<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ariel Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

  <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .layout-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 200px;
            background-color: white;
            border-right: 1px solid #ccc;
            padding: 20px;
        }
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .header {
            height: 70px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        main {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
    </style>
<body>

    {{-- Header luôn nằm trên cùng, full width --}}
    @include('layouts.header')

    {{-- Bố cục nội dung gồm sidebar + content --}}
    <div class="d-flex">
        {{-- Sidebar bên trái --}}
        @include('layouts.sidebar')

        {{-- Nội dung chính --}}
        <div class="flex-grow-1">
            @yield('content')
        </div>
    </div>

</body>
</html>
