@extends('layouts.errormaster')
@section('title', __('Service Unavailable'))
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
                        <h1>5<span>0</span>3</h1>
                          <h1 class="mb-2">Service Unavailable</h1>
                        <p class="font-16">Oops! Something went wrong internal server Error.</p>
                        <a href="{{ route('admin.login.login') }}" class="btn btn-primary">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

