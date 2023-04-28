@section('title', __('Page Not Found'))
@extends('layouts.errormaster')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-body">            
            <div class="auth-wrapper auth-v1">
                <div class="auth-inner">
                    <a href="javascript:void(0);" class="brand-logo">
                        <img src="{{asset(config('const.APP_LOGO'))}}" alt="" class="" height="200">                   
                    </a>                  
                    <div class="page-title">
                        <h1>404</h1>
                        <h1 class="mb-2">Page Not Found 🕵🏻‍♀️</h1>
                        <p class="font-16">Oops! The requested URL was not found on this server.</p>
                        <a href="{{ route('admin.login.login') }}" class="btn btn-primary">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
