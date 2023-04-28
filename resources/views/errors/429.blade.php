@extends('layouts.errormaster')
@section('title', __('Too Many Requests'))
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">       
        <div class="content-body">
            <div class="auth-wrapper auth-v1">
                <div class="auth-inner py-2">
                    <a href="javascript:void(0);" class="brand-logo">
                        <img src="{{asset(config('const.APP_LOGO'))}}" alt="" class="img-fluid">                        
                    </a>      
                    <div class="page-title">
                        <h1>4<span>2</span>9</h1>
                        <h1 class="mb-2">Too Many Requests</h1>
                        <p class="font-16">Oops! We're sorry, but you have sent too many requests to us recently. Please try again later.</p>
                        <a href="{{ route('admin.login.login') }}" class="btn btn-primary">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
