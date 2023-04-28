@extends('layouts.master')
@section('title',$singular_name . ' Details')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-user.css') }}">
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">{{$singular_name}} Details</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.' . $route . '.index') }}">{{$title}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{$singular_name}} Details
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <div class="dropdown">
                        <a href="{{route('admin.' . $route . '.index')}}"> <button type="button" class="btn btn-primary"><i data-feather="arrow-left"></i> Back</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="bs-stepper checkout-tab-steps">
                <!-- Wizard starts -->
                <div class="bs-stepper-header">
                    <div class="step" data-target="#step-show-user">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather='user-check' class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{$singular_name}} Details</span>
                            </span>
                        </button>
                    </div>
                </div><br>
                <!-- Wizard ends -->

                <div class="bs-stepper-content">
                    <!-- User Details Starts -->
                    <div id="step-show-user" class="content">
                        <section class="app-user-view">
                            @include('admin.errors.error')
                            <!-- User Card & Plan Starts -->
                            <div class="row">
                                <!-- User Card starts-->
                                <div class="col-xl-12 col-lg-8 col-md-7">
                                    <div class="card user-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-12 mt-2 mt-xl-0">
                                                    <div class="user-info-wrapper">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="user-info-title">
                                                                <i data-feather="user" class="mr-1"></i>
                                                                <span class="card-text user-info-title font-weight-bold mb-0">Title</span>
                                                            </div>
                                                            <p class="card-text mb-0">{{ $role->name }}</p>
                                                        </div>


                                                    </div>
                                                </div>
                                                @if($role->name !== 'User')

                                                <div class="col-xl-8 col-lg-12 mt-2 mt-xl-0">
                                                    <!-- User Permissions -->
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-borderless">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th>Module</th>
                                                                        <th>View</th>
                                                                        <th>Add</th>
                                                                        <th>Edit</th>
                                                                        <th>Delete</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($datas as $key => $data)
                                                                    <tr>
                                                                        <td>{{$key}}</td>
                                                                        @foreach($data as $permission)
                                                                        @if($role->name !== 'Super Admin')
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input view custom_permission_checkbox" data-id="{{ $permission->id }}" id="view_{{ $permission->id }}_view" name="permissions[]" value="{{$permission->id}}" {{ isset($permissionsIds) && in_array($permission->id,$permissionsIds) ? 'checked' : '' }} disabled>
                                                                                <label class="custom-control-label" for="view_{{ $permission->id }}_view"></label>
                                                                            </div>
                                                                        </td>
                                                                        @else
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input view custom_permission_checkbox" data-id="{{ $permission->id }}" id="view_{{ $permission->id }}_view" name="permissions[]" value="{{$permission->id}}" checked disabled>
                                                                                <label class="custom-control-label" for="view_{{ $permission->id }}_view"></label>
                                                                            </div>
                                                                        </td>
                                                                        @endif
                                                                        @endforeach
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- /User Permissions -->
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card Ends-->

                            </div>
                            <!-- User Card & Plan Ends -->
                        </section>
                    </div>
                    <!-- User Details Ends -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END: Content-->
@section('script')
<script src="{{ asset('app-assets/js/scripts/pages/app-user-view.js') }}"></script>
@endsection
@endsection