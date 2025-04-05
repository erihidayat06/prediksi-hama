<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">



    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .main {
            margin-top: 0px;
            margin-bottom: 100px;
        }

        @media (max-width: 576px) {
            .main {
                margin-top: 0px;
                margin-bottom: 100px;
            }
        }

        @media (max-width: 576px) {

            p {
                font-size: 12px;
            }

            .keterangan {
                font-size: 14px;
            }

            h5 {
                font-size: 16px;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    @include('layoute.header')
    <main class="main">

        @yield('content')

    </main>
    @include('layoute.footer')
    @include('layoute.bottom')



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            let scrollPosition = sessionStorage.getItem("scrollPosition");
            if (scrollPosition !== null) {
                document.documentElement.style.visibility = "hidden"; // Sembunyikan halaman sementara
                requestAnimationFrame(() => {
                    window.scrollTo(0, scrollPosition);
                    document.documentElement.style.visibility =
                        "visible"; // Tampilkan kembali setelah scroll selesai
                });
            }

            window.addEventListener("beforeunload", function() {
                sessionStorage.setItem("scrollPosition", window.scrollY);
            });
        });
    </script>




</body>

</html>
