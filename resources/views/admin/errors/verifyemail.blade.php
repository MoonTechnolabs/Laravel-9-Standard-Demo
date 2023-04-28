@extends('layouts.loginmaster')
@section('title', 'Email Verfication')
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
                            <img src="{{ asset(config('const.APP_LOGO')) }}" alt="" class="img-fluid">
                        </a>
                        <div class="page-title">
                            <h1>Please verify your email id link is already sent</h1>
                            <h5>Did not recieved Email? click below button to resend email</h5>
                            <form action="{{ route('verification.send') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary resend_btn">
                                    <span class="align-middle">Resend</span>
                                    <span class="spinner-border spinner-border-sm ml-1 display-none loader-btn"
                                        role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@section('script')   
    <script>
        $(document).ready(function() {
            $('.resend_btn').on('click', function() {
                $('.loader-btn').removeClass("display-none");
                $(".submitbutton").attr("type", "button");
                $('.submitbutton').prop('disabled', true);
            })
        });
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
@endsection
@endsection
