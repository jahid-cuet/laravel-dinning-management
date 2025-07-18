<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Free minimal portfolio web site template,minmal portfolio,porfolio,bootstrap template,html template,photography " />

    <!-- site title -->
    <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>

    <link rel="icon" href="{{ asset(getSetting('favicon', 'assets/images/favicon.png')) }}" type="image/x-icon">


    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">


    <!-- build:css -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- endbuild -->

    <!-- custom css option -->
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/rtl.css')}}">

    {{-- sweetalert --}}
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>

<body>
    <!-- ========== section start ========== -->
    <main role="main">
        @yield('content')
    </main>
    <!-- ========== section end ========== -->

<!-- template's footer -->


    <!-- template's all script -->
    <!-- vendor plugins -->
    <script src="https://kit.fontawesome.com/1c5d30a313.js" crossorigin="anonymous"></script>
    <script src="{{asset('assets/vendor/js/bootstrap/bootstrap.bundle.min.js')}}"></script>



    <!-- Template js -->
    <script type="script" src="{{asset('assets/js/auth.js')}}"></script>
    <!-- =========<< Js Script start here >>=========== -->
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>


    <!-- Template js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @if (session('success'))
    <script>
        SwalNotification('Success', "{{ session('success') }}", 'success');
    </script>
    @endif

    @if (session('status'))
    <script>
        SwalNotification('Success', "{{ session('status') }}", 'success');
    </script>
    @endif

    @if (session('error'))
    <script>
        SwalNotification('Error', "{{ session('error') }}", 'error');
    </script>
    @endif

    @if (session('warning'))
    <script>
        SwalNotification('Warning', "{{ session('warning') }}", 'warning');
    </script>
    @endif

    @yield('js')
</body>

</html>