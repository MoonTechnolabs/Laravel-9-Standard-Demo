@extends('layouts.loginmaster')
@section('title', 'Success')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="right-img ">
                    <a href="javascript:void(0);" class="brand-logo">
                        <img height="30" src="{{asset(config('const.APP_LOGO'))}}" alt="">
                        <h2 class="brand-text text-primary ml-20">{{config('const.APP_NAME')}}</h2>
                    </a>                    
                </div>
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <div class="page-title">
                            
                            <h6>Your Account is Verified.</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
