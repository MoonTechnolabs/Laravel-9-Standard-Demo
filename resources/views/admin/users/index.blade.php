<?php

use Request as Input;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
?>
@extends('layouts.master')
@section('title',$title)
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
                            <h2 class="content-header-title float-left mb-0">{{$title}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{$title}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->can('create-user'))
                    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                        <div class="form-group breadcrumb-right">
                            <div class="dropdown">
                                <a href="{{ route('admin.' . $route . '.create') }} "> <button type="button"
                                        class="btn btn-primary"><i data-feather="plus"></i> Add {{$singular_name}}</button></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="{{ route('admin.' . $route . '.index') }}" class="nav-link active" id="home-tab"
                                aria-expanded="true">{{$title}}</a>
                        </li>
                        @if (auth()->user()->can('list-role'))
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link" id="profile-tab"
                                    aria-expanded="false">Roles</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <form method="POST" action="" accept-charset="UTF-8" class="form-horizontal" id="filterData"
                name="filterData" novalidate="novalidate">
                <div class="card">
                    <div class="card-body">                       
                        <div class="row">                         
                            <div class="col-lg-12">
                                <div class="col-lg-2 float-right">
                                    <div class="form-group">
                                        <label for="basicSelect">Roles</label>

                                        <select class="form-control" id="role_id" name="role_id">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 float-right">
                                    <div class="form-group">
                                        <label for="basicSelect">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="{{ config('const.statusActiveInt') }}">Active</option>
                                            <option value="{{ config('const.statusInActiveInt') }}">InActive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <div class="content-body">
                <!-- Basic table -->
                <section id="ajax-datatable">
                    <div class="row">
                        <div class="col-12">
                            @include('admin.errors.error')
                            <div class="card">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="user-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    @include('admin.confirmalert')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#status').select2({
                selectOnClose: true,
            });

            $('#role_id').select2({
                selectOnClose: true,
            });
            var initTable1 = function() {
                var table = $('#user-table');
                // begin first table
                table.DataTable({
                    lengthMenu: getPageLengthDatatable(),
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url: "{{ route('admin.getusers') }}",
                        type: 'post',
                        data: function(data) {
                            data.fromValues = $("#filterData").serialize();
                        }
                    },
                    columns: [{
                            data: 'name',
                            name: 'name',
                            defaultContent: ''
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            sortable: false,
                            responsivePriority: -1
                        },
                    ],
                });
            };
            initTable1();
            $("#status,#role_id").bind("change", function() {
                $('#user-table').DataTable().draw();
            });
            $("#delete-record").on("click", function() {
                var id = $("#id").val();
                var deleteUrl = baseUrl + '/admin/users/' + id;
                $('#delete-modal').modal('hide');
                $.ajax({
                    url: deleteUrl,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(data) {
                        toastr.success("@lang('admin.recordDelete')", "@lang('admin.success')");
                        $('#user-table').DataTable().draw();
                    },
                    error: function(data) {
                        toastr.error("@lang('admin.oopserror')", "@lang('admin.error')");
                    }
                });
            });
        });
    </script>
@endsection
