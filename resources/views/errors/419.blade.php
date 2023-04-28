@extends('layouts.errormaster')
@section('title', __('Page Expired'))
@section('content')
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
                        <h1>4<span>1</span>9</h1>
                          <h1 class="mb-2">Page Expired</h1>
                          <p class="font-16">Sorry. Your session has expired. Please refresh and try again.</p>                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('message', __('Page Expired'))
