<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> WI-Mart </title>

        <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="{{ asset('assets/vendors/gaxon-icon/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @include('layouts.backend.data.style')
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/bootstrap.min.css" type="text/css">
        <script src="https://kit.fontawesome.com/f076b04045.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/elegant-icons.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/jquery-ui.min.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/magnific-popup.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/owl.carousel.min.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/slicknav.min.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('ashion') }}/css/style.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('stisla') }}/css/style2.css">
        <link rel="stylesheet" href="{{ asset('stisla') }}/css/components.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <body>
        @include('layouts.backend.data.nav')
        <main>
            <h1 class="title">{{$title}}</h1>
			<ul class="breadcrumbs">
				<li><a href="#">{{isset($parent)}}</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Dashboard</a></li>
			</ul>
            @yield('content')
        </main>
        </section>
        @include('layouts.backend.data.script')
        <script src="{{ asset('ashion') }}/js/jquery-3.3.1.min.js"></script>
        <script src="{{ asset('ashion') }}/js/bootstrap.min.js"></script>
        <script src="{{ asset('ashion') }}/js/jquery.magnific-popup.min.js"></script>
        <script src="{{ asset('ashion') }}/js/jquery-ui.min.js"></script>
        <script src="{{ asset('ashion') }}/js/mixitup.min.js"></script>
        <script src="{{ asset('ashion') }}/js/jquery.countdown.min.js"></script>
        <script src="{{ asset('ashion') }}/js/jquery.slicknav.js"></script>
        <script src="{{ asset('ashion') }}/js/owl.carousel.min.js"></script>
        <script src="{{ asset('ashion') }}/js/jquery.nicescroll.min.js"></script>
        <script src="{{ asset('ashion') }}/js/main.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('custom/library/select2/dist/js/select2.min.js') }}"></script> --}}
        <script src="{{ asset('assets/vendors/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/vfs_fonts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        @stack('after-scripts')
    </body>
</html>
