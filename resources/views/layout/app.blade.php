<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel with Toggle Sidebar</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
    
    @include('layout.sidebar')

        <div id="main-content" class="main-content">
            @include('layout.topbar')  

                <div class="container-fluid mt-4">

                    <!-- Main Content -->
                
                    @yield('content')

            </div>
            
           @include('layout.footer')
        </div>
       <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>

        function toggleSidebar() {

            document.getElementById("sidebar")
                .classList.toggle("collapsed");

            document.getElementById("main-content")
                .classList.toggle("expanded");
        }

        document.getElementById("year").textContent =
            new Date().getFullYear();

    </script>

</body>
</html>
