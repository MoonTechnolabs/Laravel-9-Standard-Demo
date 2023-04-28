@extends('layouts.master')
@section('title','Update '  . $singular_name)
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
                        <h2 class="content-header-title float-left mb-0">Update {{$singular_name}}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.' . $route . '.index') }}">{{$singular_name}} Management</a>
                                </li>
                                <li class="breadcrumb-item active">Update {{$singular_name}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- users edit start -->
            <section class="app-user-edit">
                @include('admin.errors.error')
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Account Tab starts -->
                            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                <!-- users edit account form start -->
                                {{ Form::model($role, ['route' => ['admin.' . $route . '.update',$role->id], 'method' => 'patch','id'=>'editform','name'=>'editform','enctype'=>'multipart/form-data']) }}                                                                                     
                                @include('admin.' . $route . '.common')
                                {!! Form::close() !!} 
                                <!-- users edit account form ends -->
                            </div>
                            <!-- Account Tab ends -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- users edit ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {

        /* Initialize Select2 */
        $("#status").select2({
            placeholder: "Select Status",
            allowClear: true
        });

        $("select").on("select2:close", function (e) {
            $(this).valid();
        });

        $("#editform").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                status: {
                    required: true,
                }
            },
            submitHandler: function (form) {
                if ($("#editform").validate().checkForm()) {
                    $(".submitbutton").addClass("disabled");
                    $('.indicator-progress').removeClass("d-none");
                    form.submit();
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("id") == "status") {
                    error.appendTo(element.parent("div"));
                } else {
                    error.insertAfter(element);
                }
            },
        });

        $('.checkall_role').click(function() {
            var isChecked = false;
            $('#role-table').find('.custom_permission_checkbox').each(function(index) {
                if ($(this).prop('checked') == true) {
                    isChecked = true;
                }
            })
            if (isChecked == true) {
                $(".custom_permission_checkbox").prop("checked", false);
            } else {
                $(".custom_permission_checkbox").prop("checked", true);
            }
        })

        $(".custo_allow_all").click(function() {
            // console.log('inside');
            var isChecked = false;
            $(this).parent().parent().find('.custom_permission_checkbox').each(function() {
                if ($(this).prop('checked') == true) {
                    isChecked = true;
                }
            });
            if (isChecked == true) {
                $(this).parent().parent().find('.custom_permission_checkbox').each(function() {
                    $(this).prop('checked', false)
                });
            } else {
                $(this).parent().parent().find('.custom_permission_checkbox').each(function() {
                    $(this).prop('checked', true)
                });
            }
        });


    });
</script>
@endsection
