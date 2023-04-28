@extends('layouts.loginmaster')
@section('title','Login')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="brand-logo">
                                <img width="250" src="{{asset(config('const.APP_LOGO'))}}" alt="">
                            </a>
                            <h4 class="card-title mb-1">Welcome to {{config('const.APP_NAME')}}! 👋</h4>
                            <p class="card-text mb-2">Please sign-in to your account</p>

                            <form class="auth-login-form mt-2" id="login_form" name="login_form" action="{{route('admin.login.login')}}" method="POST">
                                <input type="hidden" id="timezone" name="timezone">
                                @csrf
                                @include('admin.errors.error')
                                <div class="form-group">
                                    <label for="login-email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="john@example.com" aria-describedby="email" tabindex="1" value="{{old('email')}}" autofocus />
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label for="login-password">Password</label>
                                        <a href="{{route('password.request')}}">
                                            <small>Forgot Password?</small>
                                        </a>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" name="password" id="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block submitbutton" tabindex="4">
                                    <span class="align-middle">Sign in</span>
                                    <span class="spinner-border spinner-border-sm ml-1 display-none loader-btn" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('script')
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.26/moment-timezone-with-data-10-year-range.js"></script>

<!-- BEGIN: Page JS-->

<!-- END: Page JS-->
<script>
    var tz = moment.tz.guess();
    document.cookie = "headvalue=" + tz;
    $(document).ready(function() {
        $('#timezone').val(tz);
        $("#login_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true
                },
            },
            submitHandler: function(form) {
                $('.loader-btn').removeClass("display-none");
                $(".submitbutton").attr("type", "button");
                $('.submitbutton').prop('disabled', true);
                form.submit();
            }
        });
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