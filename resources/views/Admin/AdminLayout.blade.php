<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="{{ url('public/admin/css/styles.css') }}" rel="stylesheet" />
    <script src="{{ url('public/admin/js/all.js') }}"></script>
    <script src="{{ url('public/admin/js/jquery.min.js') }}"></script>
    <script src="{{ url('public/admin/js/sweetalert.min.js') }}"></script>
    <link href="{{ url('public\admin\plugin\datatable\datatables.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('public/admin/assets/summernote/summernote-lite.min.css') }}">

</head>
<style>
    /* Loading overlay styles */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
        /* Initially hidden */
    }
</style>
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index">Contact Admin</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item">{{ $_SESSION['user_name'] }}</a></li>
                    {{-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> --}}
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                        <a class="nav-link" href="{{ route('Dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>


                        <a class="nav-link" href="{{ route('Contact') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                            Email
                        </a>



                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ $_SESSION['user_name'] }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            @yield('content')

        </div>
    </div>

    <script>
        function showLoading() {
            $('#loadingOverlay').fadeIn();
        }

        // Hide the loading overlay
        function hideLoading() {
            $('#loadingOverlay').fadeOut();
        }
    </script>
    <script src="{{url('public/admin/js/bootstrap.bundle.min.js')}}" crossorigin="anonymous">
    </script>
    <script src="{{ url('public/admin/js/scripts.js') }}"></script>
    <script src="{{ url('public/admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ url('public\admin\plugin\datatable\datatables.min.js') }}"></script>
    <script src="{{url('public/admin/js/xlsx.full.min.js')}}"></script>

</body>

</html>
