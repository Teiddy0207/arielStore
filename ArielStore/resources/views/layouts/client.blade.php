<!DOCTYPE html>
<html lang="vi">
<!-- Nhìn thấy cái file client này không  -->
 <!-- Cái này là để gọi header , fofoot, content trong   trang của  đấy  -->
  <!-- Trong này nó có thư viện , thì cái header gọi như anh gọi nó mới dùng được  -->
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ariel Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>

</style>

<body>

    @include('layouts.headerClient')
    @yield('content')
    @include('layouts.footerClient')

    <!-- Đây là phần nội dung trong trang của  bao gồm header foooter và content  -->

</body>

</html>