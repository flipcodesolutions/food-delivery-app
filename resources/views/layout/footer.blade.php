<!-- Footer -->
        <footer>
                <link rel="stylesheet" href="{{asset('css/style.css')}}">

            <small>
                © <span id="year"></span> Click to Care. All rights reserved.&nbsp;

            </small>
        </footer>
         <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
        <script>
            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("collapsed");
                document.getElementById("main-content").classList.toggle("expanded");
            }
        </script>
        <script>
             document.getElementById("year").textContent = new Date().getFullYear();
         </script>
        </body>
        </html>