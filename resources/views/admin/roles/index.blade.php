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

            @if(Auth::user()->can('create-role'))
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <div class="dropdown">
                        <a href="{{ route('admin.roles.create')}} "> <button type="button" class="btn btn-primary"><i data-feather="plus"></i> Add {{$singular_name}}</button></a>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <div class="content-body">

            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link" id="home-tab" aria-expanded="true">Users</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link active" id="profile-tab" aria-expanded="false">{{$title}}</a>
                </li>               
            </ul>

            <!-- Basic table -->
            <section id="ajax-datatable">                
                <div class="row">
                    <div class="col-12">
                        @include('admin.errors.error')
                        <div class="card">
                            <div class="card-datatable">
                                <table class="datatables-ajax table" id="user-roles-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Is System Default Role</th>
                                            <th>Created at</th>                                           
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
$(document).ready(function () {
    var table = $('#user-roles-table');
    table.DataTable({
            lengthMenu: getPageLengthDatatable(),
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "{{route('admin.getroles')}}",
                type: 'post',
                data: function (data) {
                    data.fromValues = $("#filterData").serialize();
                }
            },
            columns: [
                {data: 'name', name: 'name', defaultContent: ''},
                {data: 'is_system_generated', name: 'is_system_generated', sortable: false, searchable: false},
                {
                    data: 'created_at', name: 'created_at',
                    render: function (data, type, row, meta) {
                        var dateWithTimezone = moment.utc(data).tz(tz);
                        return dateWithTimezone.format('<?php echo config('const.JsDisplayDateTimeFormatWithAMPM'); ?>');
                    }
                },
                {data: 'action', name: 'action', searchable: false, sortable: false,responsivePriority: -1},
            ],
    });
    table.DataTable().draw();

    $("#delete-record").on("click", function () {
        var id = $("#id").val();
        $('#delete-modal').modal('hide');
        $.ajax({
            url: baseUrl + '/admin/roles/' + id,
            type: "DELETE",
            dataType: 'json',
            success: function (data) {
                if (data == 'Error') {
                    toastr.error('@lang('admin.somethingWrong')');
                } else {
                    toastr.success('@lang('admin.recordDelete')', '@lang('admin.success')');
                    table.DataTable().draw();
                    initTable1();
                }
            },
            error: function (data) {
                toastr.error("@lang('admin.oopserror')", "@lang('admin.error')");
            }
        });
    });
});
</script>
@endsection
