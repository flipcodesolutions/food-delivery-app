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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
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
