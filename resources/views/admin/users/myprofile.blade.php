@extends('layouts.master')
@section('title','My Profile')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">My Profile</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <!-- <li class="breadcrumb-item"><a href="#">Pages</a>
                                </li> -->
                                <li class="breadcrumb-item active"> My Profile
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="content-body">
            <!-- account setting page -->
            <section id="page-account-settings">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-3 mb-2 mb-md-0">
                        <ul class="nav nav-pills flex-column nav-left">
                            <!-- Profile Start -->
                            <li class="nav-item">
                                <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                    <i data-feather="user" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">Profile</span>
                                </a>
                            </li>
                            <!-- Profile End -->
                            <!-- Change Password Start -->
                            <li class="nav-item">
                                <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                    <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">Change Password</span>
                                </a>
                            </li>
                            <!-- Change Password Start -->
                        </ul>
                    </div>
                    <!--/ left menu section -->

                    <!-- right content section -->
                    <div class="col-md-9">
                        @include('admin.errors.error')
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- general tab -->
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                        <form action="{{route('admin.profile.update',$user)}}" id="profile_update_form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <!-- header media -->
                                            <div class="media">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <br>
                                                            <label for="image">
                                                                <input type="file" name="image" id="image" style="display:none;" onchange="loadFile(event)" accept="image/*">
                                                                <img style="display: block;cursor: pointer;" src="{{ $user->image }}" id="account-upload-img" class="rounded mr-50" alt="Profile Image" height="80" width="80">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ header media -->
                                            <!-- <br> -->
                                            <div class="row">
                                                <div class="col-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-username">Name</label>
                                                        <input type="text" name="name" id="name" placeholder="Enter Name" value="{{old('name',$user->name)}}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-e-mail">E-mail</label>
                                                        <input type="text" name="email" id="email" value="{{$user->email}}" class="form-control" placeholder="Enter Email" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mt-2 mr-1 submitbutton">
                                                        <span class="indicator-label d-flex align-items-center justify-content-center">Save Changes
                                                            <span class="indicator-progress d-none loader-btn"> &nbsp;&nbsp;&nbsp;
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                            </span>
                                                        </span>
                                                    </button>
                                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mt-2 profile-cancel">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!--/ general tab -->

                                    <!-- change password -->
                                    <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <!-- form -->
                                        <form action="{{route('admin.password.update',$user)}}" method="POST" class="validate-form change-password-form" id="password_change_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-old-password">Old Password</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter Old Password" maxlength="100" autocomplete="oldpassword" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer">
                                                                    <i data-feather="eye"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-new-password">New Password</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter New Password" autocomplete="password" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer">
                                                                    <i data-feather="eye"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-retype-new-password">Confirm New Password</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm New Password" autocomplete="password_confirmation" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mt-1 password-submit">
                                                        <span class="indicator-label d-flex align-items-center justify-content-center">Change Password
                                                            <span class="indicator-progress d-none loader-btn" id="update-indicator-progress"> &nbsp;&nbsp;&nbsp;
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                            </span>
                                                        </span>
                                                    </button>
                                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mt-1 password-cancel">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                        <!--/ form -->
                                    </div>
                                    <!--/ change password -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ right content section -->
                </div>
            </section>
            <!-- / account setting page -->

        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('script')
<script>
    /* Profile Preview Start */

    function loadFile(event) {
        var output = document.getElementById('account-upload-img');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    }
    $(document).ready(function() {

        $('#profile_update_form').validate({
            rules: {
                name: 'required',
            },
            submitHandler: function(form) {
                $('.loader-btn').removeClass("d-none");
                $(".submitbutton").attr("type", "button");
                $('.submitbutton').prop('disabled', true);
                form.submit();
            }
        });

        $("#password_change_form").validate({
            rules: {
                oldpassword: {
                    required: true,
                    password: false,
                },
                password: {
                    required: true,
                    minlength: 8,
                    password: true,
                    maxlength: 20,
                },
                password_confirmation: {
                    required: true,
                    password: false,
                    equalTo: "#password"
                },
            },
            submitHandler: function(form) {
                $('.loader-btn').removeClass("d-none");
                $(".submitbutton").attr("type", "button");
                $('.submitbutton').prop('disabled', true);
                form.submit();
            }
        });

        $.validator.addMethod("password", function(value, element) {
            let password = value;
            if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[#?!@$%^&*-])/.test(password))) {
                return false;
            }
            return true;
        }, function(value, element) {
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