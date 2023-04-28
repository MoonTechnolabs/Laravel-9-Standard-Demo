<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Name', 'Name',['class'=>'form-label','for'=>'name']); !!}    
            {!! Form::text('name',Input::old('name',isset($user)?$user->name:'') ,['id'=>'name','class' => 'form-control',"placeholder"=>"Enter Name"]); !!}                      
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">            
            {!! Form::label('Email', 'Email',['class'=>'form-label','for'=>'email']); !!}               
            {!! Form::email('email', Input::old('email',isset($user)?$user->email:''),['id'=>'email','class' => 'form-control',"placeholder"=>"Enter Email"]) !!}            
        </div>
    </div>
</div>
@if(isset($user))
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="checkboxshow" id="checkboxshow" @checked(old('checkboxshow'))>
                <label class="custom-control-label" for="checkboxshow">Do you want to change password ?</label>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row" id="password_detail">
    <div class="col-md-6">
        <div class="form-group">
            <label for="account-new-password">Password</label>
            <div class="input-group form-password-toggle input-group-merge">
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" maxlength="100" autocomplete="new-password" />
                <div class="input-group-append">
                    <div class="input-group-text cursor-pointer">
                        <i data-feather="eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="basic-default-password">Confirm Password</label>
            <div class="input-group form-password-toggle input-group-merge">
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter Confirm Password" maxlength="100">
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
    <div class="col-md-6">
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role_id" class="form-control" name="role_id">
                <option value="">Select Role</option>
                @if($roles && count($roles) > 0)
                @foreach($roles as $role)
                    <option {{ isset($user) && ($user->roles[0]->id == $role->id) ? 'selected' : ''}} value="{{ $role->id }}">{{ $role->name }} </option>
                @endforeach
                @endIf
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach($statuses as $key => $status)
                <option value="{{$key}}" {{isset($user) && $user->status == $key ? 'selected' : ''}}>{{$status}}</option>
                @endforeach
            </select>               
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex flex-sm-row flex-column mt-2">
        @if(isset($user->id))
        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 submitbutton" name="submit" value="Submit">
            <span class="indicator-label d-flex align-items-center justify-content-center">Update
                <span class="indicator-progress d-none" id="update-indicator-progress"> &nbsp;&nbsp;&nbsp;
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </span>
        </button>&nbsp;
        @else
        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 submitbutton" name="submit" value="Submit">
            <span class="indicator-label d-flex align-items-center justify-content-center">Save
                <span class="indicator-progress d-none"> &nbsp;&nbsp;&nbsp;
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </span>
        </button>&nbsp;
        @endif
        <a href="{{ route('admin.' . $route . '.index') }}"><button type="button" class="btn btn-outline-secondary">Cancel</button></a>
    </div>
</div>