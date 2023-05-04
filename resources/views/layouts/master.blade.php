<?php

use App\Helpers\Helper;
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>{{ config('const.APP_NAME') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(config('const.FAVICO_ICON')) }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">

    <!-- BEGIN: Select2 CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/forms/select/select2.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard-ecommerce.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-wizard.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-number-input.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link href="{{ asset('assets/admin/developer/developer.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>
    @yield('css')
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i
                                class="ficon" data-feather="menu"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ml-auto">

                <!-- Notification Start -->
                <li class="nav-item dropdown dropdown-notification mr-25">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon"
                            data-feather="bell"></i>
                        <span class="badge badge-pill badge-danger badge-up alert-dots" style="display:none;"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                        <li class="dropdown-menu-header">
                            <div class="dropdown-header d-flex">
                                <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                                <!--                                    <div class="badge badge-pill badge-light-primary">6 New</div>-->
                            </div>
                        </li>
                        <li class="scrollable-container media-list custom-notifications">

                        </li>
                        <li class="dropdown-menu-footer show-all-notification"><a
                                href="#" class="btn btn-primary btn-block ">Read
                                all notifications</a></li>
                    </ul>
                </li>
                <!-- Notification End-->

                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user"
                        href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                            <span
                                class="user-name font-weight-bolder">{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}</span>
                            <span class="user-status">{{ Auth::user()->roles[0]->name }}</span>
                        </div>
                        <span class="avatar">
                            <img class="round" src="{{ auth()->user()->image }}" alt="avatar" height="40"
                                width="40">
                            <span class="avatar-status-online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}"><i class="mr-50"
                                data-feather="user"></i> Profile</a>
                        <div class="dropdown-divider"></div>

                        <form action="{{ route('admin.logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item logout-button"><i class="mr-50"
                                    data-feather="power"></i>Logout</button>
                        </form>
                        <!-- <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="mr-50" data-feather="power"></i> Logout</a> -->
                    </div>
                </li>

            </ul>

        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header margin-left-4">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <span class="brand-logo margin-left-9">
                            <svg width="30" height="30" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_198_1903)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.6245 8.7538C10.918 8.69042 11.2103 8.86369 11.2773 9.14116C11.3446 9.41863 11.1611 9.69473 10.8676 9.75834C9.76669 9.99682 8.79747 10.3915 7.95992 10.9428C7.30275 11.3753 6.72542 11.9051 6.22742 12.5328C6.37863 12.5752 6.53201 12.6114 6.68683 12.6415C7.05098 12.7122 7.43443 12.7494 7.83283 12.7494C9.3982 12.7494 10.815 12.1495 11.8407 11.1801C12.773 10.2987 13.3819 9.11152 13.4849 7.79099C11.0875 7.27504 8.96628 7.5427 7.12164 8.59398C5.13424 9.72664 3.44056 11.7713 2.04087 14.7274C1.91836 14.9869 1.59641 15.1034 1.32197 14.9873C1.04753 14.8718 0.924293 14.5672 1.0468 14.3077C1.54191 13.2621 2.07439 12.3219 2.64498 11.4865C2.19183 10.9738 1.82189 10.3917 1.55445 9.75879C1.24383 9.02329 1.07285 8.22395 1.07285 7.39109C1.07285 5.62643 1.82985 4.02865 3.05302 2.87205C4.27643 1.71544 5.96672 1 7.83331 1C8.74297 1 9.6138 1.17168 10.4108 1.48312C11.2371 1.80573 11.9806 2.27813 12.6025 2.86384C12.8157 3.06425 12.8164 3.39027 12.6044 3.59182C12.3925 3.79337 12.0476 3.79451 11.8342 3.59387C11.3113 3.10141 10.6882 2.70493 9.99676 2.43521C9.33309 2.17599 8.60237 2.03281 7.83307 2.03281C6.26793 2.03281 4.85087 2.63243 3.82522 3.60208C2.7998 4.57173 2.16531 5.91119 2.16531 7.39086C2.16531 8.09695 2.30735 8.76794 2.56587 9.37941C2.75109 9.81807 2.99683 10.2285 3.29346 10.6021C4.27956 9.35274 5.36816 8.38901 6.55877 7.71028C8.76395 6.45336 11.2932 6.17771 14.1467 6.88312C14.4006 6.92735 14.5933 7.13779 14.5933 7.39086C14.5933 9.15552 13.8363 10.7533 12.6131 11.9101C11.3899 13.0667 9.69965 13.7819 7.83307 13.7819C7.37197 13.7819 6.91545 13.7366 6.4693 13.6499C6.01158 13.5613 5.57484 13.4308 5.16414 13.2637V13.2628C5.13882 13.2523 5.11374 13.24 5.08938 13.2254C4.83472 13.0738 4.75851 12.756 4.91864 12.5155C5.57749 11.5294 6.38369 10.723 7.337 10.0955C8.2879 9.4697 9.38373 9.0226 10.6245 8.7538"
                                        fill="#7367F0" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_198_1903">
                                        <rect width="13.5938" height="14.0323" fill="white"
                                            transform="translate(1 1)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <h2 class="brand-text ml-0">{{ config('const.APP_NAME') }}</h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                            class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary"
                            data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i><span class="menu-title text-truncate"
                            data-i18n="Dashboards">Dashboard</span>
                    </a>
                </li>




            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    @yield('content')

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2022
                <span class="d-none d-sm-inline-block">, All rights Reserved</span>
            </span>
        </p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <script type="text/javascript">
        window.baseUrl = "@php echo URL::to('/'); @endphp"
    </script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/app-ecommerce-checkout.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Select2 JS-->
    <script src="{{ url('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('assets/admin/developer/developer.js') }}" type="text/javascript"></script>
    <script>
        window.siteName = "@php echo trans('messages.siteName'); @endphp"
    </script>

    <!-- Central Timexzone Management -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.26/moment-timezone-with-data-10-year-range.js">
    </script>
    <script>
         var tz = moment.tz.guess();
            document.cookie = "headvalue=" + tz;
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: baseUrl + '/settimezone',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        timezone: tz
                    },
                    success: function(data) {

                    },
                    error: function(data) {

                    }
                });
            });

    </script>
    <!-- Time Xone manage End -->

    @yield('script')
    <!-- END: Page JS-->
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>

</html>
