@extends('layouts.loginmaster')
@section('title','Reset Password')
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
                    <!-- Reset Password v1 -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="brand-logo">
                                <img width="250" src="{{asset(config('const.APP_LOGO'))}}" alt="">                              
                            </a>

                            <h4 class="card-title mb-1">Reset Password 🔒</h4>
                            <!-- <p class="card-text mb-2">Your new password must be different from previously used passwords</p> -->
                            @include('admin.errors.error')
                            <form action="{{route('password.update',['token' => Request()->token])}}" method="POST" class='auth-reset-password-form mt-2' id='password_reset_form'>

                                @csrf
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label for="reset-password-new">New Password</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="Enter New Password" aria-describedby="reset-password-new" tabindex="1" autofocus />
                                        <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="token" value="{{ request()->token }}">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label for="reset-password-confirm">Confirm Password</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password" aria-describedby="reset-password-confirm" tabindex="2" />
                                        <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block submitbutton" tabindex="3">
                                    <span class="align-middle">Set New Password</span>
                                    <span class="spinner-border spinner-border-sm ml-1 display-none loader-btn" role="status" aria-hidden="true"></span>   
                                </button>                                             
                            </form>

                            <p class="text-center mt-2">
                                <a href="{{ route('admin.login.show') }}"> <i data-feather="chevron-left"></i> Back to login </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Reset Password v1 -->
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
        $("#password_reset_form").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20,
                    password: true
                },
                password_confirmation: {
                    required: true,
                    password: false,
                    equalTo: "#password"
                },
            },
            submitHandler: function(form) {
                $('.loader-btn').removeClass("display-none");
                $(".submitbutton").attr("type", "button");
                $('.submitbutton').prop('disabled', true);
                form.submit();
            }
        });

        $.validator.addMethod("password", function (value, element) {
            let password = value;
            if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[#?!@$%^&*-])/.test(password))) {
                return false;
            }
            return true;
        }, function (value, element) {
            let password = $(element).val();
            if (!(/^(?=.*[A-Z])/.test(password))) {
                return "@lang('admin.uppercasePassword')";
            } else if (!(/^(?=.*[a-z])/.test(password))) {
               return "@lang('admin.lowercasePassword')";
            } else if (!(/^(?=.*[0-9])/.test(password))) {
                return "@lang('admin.digitPassword')";
            } else if (!(/^(?=.*[#?!@$%^&*-])/.test(password))) {
                return "@lang('admin.specialcharacterPassword')";
            }
            return false;
        });
    });
</script>
@endsection