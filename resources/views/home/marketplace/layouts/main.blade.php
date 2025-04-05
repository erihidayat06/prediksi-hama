<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>ShopGrids - Bootstrap 5 eCommerce HTML Template.</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="/img/logo-pedia.png" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets2/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="/assets2/css/tiny-slider.css" />
    <link rel="stylesheet" href="/assets2/css/glightbox.min.css" />
    <link rel="stylesheet" href="/assets2/css/main.css" />

    {{-- icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .bg-main {
            background-color: #064635;


        }

        .btn-main {
            --bs-btn-color: #F4EEA9 !important;
            --bs-btn-bg: #519259 !important;
            --bs-btn-border-color: #519259 !important;
            --bs-btn-hover-color: #F4EEA9 !important;
            --bs-btn-hover-bg: #457d4c !important;
            --bs-btn-hover-border-color: #48854f !important;
            --bs-btn-focus-shadow-rgb: 49, 132, 253 !important;
            --bs-btn-active-color: #F4EEA9 !important;
            --bs-btn-active-bg: #48854f !important;
            --bs-btn-active-border-color: #457d4c !important;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
            --bs-btn-disabled-color: #F4EEA9 !important;
            --bs-btn-disabled-bg: #519259 !important;
            --bs-btn-disabled-border-color: #519259 !important;
            border-radius: 20px !important;
            padding: 5px 10px !important;
        }
    </style>
</head>

<body>
    @include('layoute.header')
    @include('home.marketplace.layouts.header')
    @yield('content')
    @include('layoute.footer')
    @include('layoute.bottom')

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="/assets2/js/bootstrap.min.js"></script>
    <script src="/assets2/js/tiny-slider.js"></script>
    <script src="/assets2/js/glightbox.min.js"></script>
    <script src="/assets2/js/main.js"></script>
    <script type="text/javascript">
        //========= Hero Slider
        tns({
            container: ".hero-slider",
            slideBy: "page",
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: [
                '<i class="lni lni-chevron-left"></i>',
                '<i class="lni lni-chevron-right"></i>',
            ],
        });

        //======== Brand Slider
        tns({
            container: ".brands-logo-carousel",
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                },
            },
        });
    </script>
</body>

</html>
