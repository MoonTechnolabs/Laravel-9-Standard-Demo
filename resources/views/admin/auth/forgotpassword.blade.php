@extends('layouts.loginmaster')
@section('title','Forgot Password')
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
                    <!-- Forgot Password v1 -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="brand-logo">
                                <img width="250" src="{{asset(config('const.APP_LOGO'))}}" alt="">                   
                            </a>

                            <h4 class="card-title mb-1">Forgot Password? 🔒</h4>
                            <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>

                            <form class="auth-forgot-password-form mt-2" action="{{ route('password.email') }}" method="post" id="forget_password_form">
                                @csrf
                                @include('admin.errors.error')
                                <div class="form-group">
                                    <label for="forgot-password-email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" aria-describedby="forgot-password-email" tabindex="1" autofocus value="{{old('email','')}}" />
                                </div>
                                <button type="submit" class="btn btn-primary btn-block submitbutton" tabindex="2">
                                    <span class="align-middle">Send reset link</span>
                                    <span class="spinner-border spinner-border-sm ml-1 display-none loader-btn" role="status" aria-hidden="true"></span>   
                                </button>                             
                            </form>

                            <p class="text-center mt-2">
                                <a href="{{ route('admin.login.show') }}"> <i data-feather="chevron-left"></i> Back to login </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Forgot Password v1 -->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#forget_password_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
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
</script>
@endsection