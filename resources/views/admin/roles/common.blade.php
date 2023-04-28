<div class="row">  
    <div class="col-md-4">
        <div class="form-group">
            <label for="status">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Role Name" value="{{old('name',isset($role)?$role->name:'')}}">   
        </div>
    </div>                                                                              
</div>

<div class="row mt-1">
    <!-- Role Permission Starts -->
    <div class="col-md-8">
        <!-- User Permissions -->
        <div class="card">        
            <p class="card-text">Permission according to roles</p>
            <div class="table-responsive">
                <table class="table table-striped table-borderless" id="role-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Module</th>
                            <th>View</th>
                            <th>Add</th>
                            <th>Edit</th>                                           
                            <th>Delete</th>
                            <th>
                                <a href="#" id="checkall_role" class="font-s-16 checkall_role">Allow All</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $key => $data)
                       
                        <tr>
                            <td>{{$key}}</td>
                            @foreach($data as $permission)
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input view custom_permission_checkbox " 
                                           data-id="{{ $permission->id }}"
                                           id="view_{{ $permission->id }}_view"
                                           name="permissions[]" value="{{$permission->id}}" {{ isset($permissionsIds) && in_array($permission->id,$permissionsIds) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="view_{{ $permission->id }}_view"></label>
                                </div>
                            </td>

                            @if($loop->last)
                            <th>
                                <a href="#" class="custo_allow_all" id="allow_all_{{$permission->id}}">Allow All</a>
                            </th>
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
    <!-- Role Permission Ends -->
</div>

<div class="row">        
    <div class="col-12 d-flex flex-sm-row flex-column mt-2">
        @if(isset($data->id))
        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 submitbutton" name="submit" value="Submit">
            <span class="indicator-label d-flex align-items-center justify-content-center">Update
                <span class="indicator-progress d-none" id="update-indicator-progress"> &nbsp;&nbsp;&nbsp;
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </span></button>&nbsp;
        @else
        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 submitbutton" name="submit" value="Submit">
            <span class="indicator-label d-flex align-items-center justify-content-center">Save 
                <span class="indicator-progress d-none"> &nbsp;&nbsp;&nbsp;
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </span></button>&nbsp;
        @endif
        <a href="{{ route('admin.' . $route . '.index') }}"><button type="button" class="btn btn-outline-secondary">Cancel</button></a>
    </div>
</div>            
