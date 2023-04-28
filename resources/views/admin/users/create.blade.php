@extends('layouts.master')
@section('title','Create ' . $singular_name)
@section('css')
@endsection
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
                        <h2 class="content-header-title float-left mb-0">Create {{$singular_name}}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{$title}}</a>
                                </li>
                                <li class="breadcrumb-item active">Create {{$singular_name}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- users create start -->
            <section class="app-user-edit">
                @include('admin.errors.error')
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Account Tab starts -->
                            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                <!-- users create account form start -->
                                {!! Form::open(['route' => 'admin.' . $route . '.store','id'=>'createform','name'=>'createform','enctype'=>"multipart/form-data"]) !!}
                                @include('admin.' . $route . '.common')
                                {!! Form::close() !!}
                                <!-- users create account form ends -->
                            </div>
                            <!-- Account Tab ends -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- users create ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        /* Initialize Select2 */
        $("#status").select2({
            placeholder: "Select Status",
            allowClear: true
        });
        $("#role_id").select2({
            placeholder: "Select Role",
            allowClear: true
        });
        $("select").on("select2:close", function(e) {
            $(this).valid();
        });
        $("#createform").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 100
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 30
                },
                status: {
                    required: true
                },
                password: {
                    required: true,
                    password: true,
                    minlength: 8,
                    maxlength: 20
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                role_id: {
                    required: true
                }
            },
            submitHandler: function(form) {
                if ($("#createform").validate().checkForm()) {
                    $('.submitbutton').attr('disabled', true);
                    $('.indicator-progress').removeClass("d-none");
                    form.submit();
                }
            },
             /* This method is to display error message at proper place for select2 type of selects*/
            errorPlacement: function(error, element) {
                if (element.attr("id") == "role_id" || element.attr("id") == "status") {
                    error.appendTo(element.parent("div"));
                } else if (element.attr("id") == "password" || element.attr("id") == "password_confirmation") {
                    error.insertAfter(element.parent("div"));
                } else {
                    error.insertAfter(element);
                }
            },
            /* This method is used when input is invalid it will add error class*/
            highlight: function(element, errorClass, validClass) {
                if ($(element).attr("id") == "status" || $(element).attr("id") == "role_id") {
                    $($(element).parent("div")).addClass("has-error");
                } else if ($(element).attr("id") == "password" || $(element).attr("id") == "password_confirmation") {
                    $(element).addClass("has-error");
                    $($(element).parent("div")).addClass("is-invalid");
                } else {
                    $(element).addClass("has-error");
                }
            },
            /* This method is used when input is valid it will remove error class*/
            unhighlight: function(element, errorClass, validClass) {
                if ($(element).attr("id") == "status" || $(element).attr("id") == "role_id") {
                    $($(element).parent("div")).removeClass("has-error");
                } else if ($(element).attr("id") == "password" || $(element).attr("id") == "password_confirmation") {
                    $(element).removeClass("has-error");
                    $($(element).parent("div")).removeClass("is-invalid");
                } else {
                    $(element).removeClass("has-error");
                }
            }
        });
        /* Strong password validation method */
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