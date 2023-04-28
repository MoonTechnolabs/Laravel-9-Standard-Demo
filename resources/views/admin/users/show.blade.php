<?php

use Request as Input;
use App\Helpers\Helper;
?>
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{$title}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{$singular_name}} Details
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right text-right">                                
                    @if($user->roles[0]->id != config('const.roleSuperAdmin'))                        
                        @if(auth()->user()->roles[0]->id == config('const.roleSuperAdmin') || (isset($role_permission->is_edit) && $role_permission->is_edit == 1 ))
                            <div class="dropdown d-inline-block">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a>
                            </div> 
                        @endif
                    @endif
                    <div class="dropdown d-inline-block">
                        <a href="{{route('admin.' . $route . '.index')}}"> <button type="button" class="btn btn-primary"><i data-feather="arrow-left"></i> Back</button></a>
                    </div> 

                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="bs-stepper checkout-tab-steps">
                <!-- Wizard starts -->
                <div class="bs-stepper-header">
                    <div class="step {{ Route::is('users')  ? 'active' : '' }}" data-target="#step-show-user">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="user" class="font-medium-3"></i>
                            </span>
                            <a href="{{ route('admin.' . $route . '.show',$user) }}">
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">{{$singular_name}} Details</span>
                                </span>
                            </a>
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
                                                <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                                    <div class="user-avatar-section">
                                                        <div class="d-flex justify-content-start">
                                                            <img class="img-fluid rounded" src="{{$user->image}}" style="max-height:104px !important" width="104" alt="User avatar" />
                                                            <div class="d-flex flex-column ml-1">
                                                                <div class="user-info mb-1">
                                                                    <h4 class="mb-0">{{$user->name}}</h4>
                                                                    <span class="card-text">{{$user->email}}</span>
                                                                </div>                                                                                                                                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                                    <div class="user-info-wrapper">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="user-info-title">
                                                                <i data-feather="user" class="mr-1"></i>
                                                                <span class="card-text user-info-title font-weight-bold mb-0">Name</span>
                                                            </div>
                                                            <p class="card-text mb-0">{{$user->name}}</p>
                                                        </div>

                                                        <div class="d-flex flex-wrap my-50">
                                                            <div class="user-info-title">
                                                                <i data-feather="star" class="mr-1"></i>
                                                                <span class="card-text user-info-title font-weight-bold mb-0">Role</span>
                                                            </div>
                                                            <p class="card-text mb-0">{{implode(',',$user->roles->pluck('name')->toArray())}}</p>
                                                        </div>

                                                        <div class="d-flex flex-wrap my-50">
                                                            <div class="user-info-title">
                                                                <i data-feather="check" class="mr-1"></i>
                                                                <span class="card-text user-info-title font-weight-bold mb-0">Status</span>
                                                            </div>
                                                            <p class="card-text mb-0">{!! Helper::Status($user->status) !!}</p>
                                                        </div>

                                                    </div>
                                                </div>
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
@endsection
