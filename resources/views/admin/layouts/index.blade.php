<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>SIMPEG Universitas Nurul Jadid</title>
    <meta name="description"
          content="Sistem Kepegawaian Universitas Nurul Jadid - Akses semua layanan digital dengan satu akun">
    <meta name="author" content="Universitas Nurul Jadid">
    <meta name="publisher" content="Pusat Data & Sistem Informasi Universitas Nurul Jadid">
    <meta name="language" content="Indonesian">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noodp, noydir, nocache, notranslate">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet, notranslate">
    <meta name="bingbot" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="slurp" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="duckduckbot" content="noindex, nofollow, noarchive, nosnippet">
    <link rel="icon" href="{{ asset('assets/media/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fonts/font.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/request.js') }}"></script>
    <script src="{{ asset('assets/js/errorhandler.js') }}"></script>
    @yield('css')
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <div id="kt_aside" class="aside aside-dark aside-hoverable"
             data-kt-drawer="true"
             data-kt-drawer-name="aside"
             data-kt-drawer-activate="{default: true, lg: false}"
             data-kt-drawer-overlay="true"
             data-kt-drawer-width="{default:'200px', '300px': '250px'}"
             data-kt-drawer-direction="start"
             data-kt-drawer-toggle="#kt_aside_mobile_toggle">
            <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                <p class="text-white fw-bold fs-4 p-2">Universitas Nurul Jadid</p>
            </div>
            <div class="aside-menu flex-column-fluid">
                @include('admin.layouts.menu')
            </div>
        </div>
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('admin.layouts.header')
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <ul class="breadcrumb breadcrumb-separatorless fw-bold mt-5 ">
                    @yield('list')
                </ul>
            </div>
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    @yield('content')
                </div>
            </div>
            @include('admin.layouts.footer')
        </div>
    </div>
</div>
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"/>
            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                  fill="black"/>
        </svg>
    </span>
</div>
<script src="{{ asset('assets/plugins/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/js/dateformat.js') }}"></script>
@yield('javascript')
</body>

</html>
