@inject('translator', 'App\Providers\TranslationProvider')
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ $description }}">

        <title>{{ $title }}</title>
	<meta name="keywords" content="{{ $keywords }}" />
	<meta name="author" content="" />

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href="{{ asset('https://fonts.googleapis.com/css?family=Poppins:300,400,500') }}'" rel="stylesheet">
	<link href="{{ asset('https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i') }}" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
	<!-- Flexslider  -->
	<link rel="stylesheet" href="{{ asset('css/flexslider.css') }}">
	<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}">
	<!-- Date Picker -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">

	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('https://use.fontawesome.com/releases/v5.3.1/css/all.css')}}" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


	<!-- Modernizr JS -->
	<script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
	<!-- jQuery -->
	<script src="{{ asset('js/jquery.min.js')}}"></script>
	<!-- jQuery Easing -->
	<script src="{{ asset('js/jquery.easing.1.3.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('js/bootstrap.min.js')}}"></script>
	<!-- Waypoints -->
	<script src="{{ asset('js/jquery.waypoints.min.js')}}"></script>
	<!-- Parallax -->
	<script src="{{ asset('js/jquery.stellar.min.js')}}"></script>
	<!-- Owl Carousel -->
	<script src="{{ asset('js/owl.carousel.min.js')}}"></script>
	<script src="{{ asset('js/sweetalert.min.js')}}"></script>
	<!-- Magnific Popup -->
	<script src="{{ asset('js/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{ asset('js/magnific-popup-options.js')}}"></script>
	<!-- Flexslider -->
	<script src="{{ asset('js/jquery.flexslider-min.js')}}"></script>
	<!-- Date Picker -->
	<script src="{{ asset('js/bootstrap-datepicker.js')}}"></script>

	<!-- Main JS (Do not remove) -->
	<script src="{{ asset('js/main.js')}}"></script>

        <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js')}}"></script>
        <script src="{{ asset('/js/jsrender.min.js')}}"></script>
        <script src="{{ asset('/js/jquery.easyPaginate.js')}}"></script>
        <script src="{{ asset('/js/jquery-ui.min.js')}}"></script>
        {!! $header !!}
        <div class="body">
            {!! $errors !!}
            {!! $content !!}
        </div>
    </body>
    {!! $footer !!}
</html>
