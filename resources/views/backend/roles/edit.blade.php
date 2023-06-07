@extends('backend.layouts.app')
@section('title', 'Role Edit')
@section('css')
<style>
    .custom-control-label {
        text-transform: capitalize;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">

        <div class="card">
            <form class="needs-validation" novalidate="" action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @method('PUT')
                @csrf
            <div class="card-header">
                <h4>Edit Role</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label  class="section-title mt-0">Role Name</label>
                    <input type="text" class="form-control" required="" name="name"  value="{{ $role->name }}">
                    <div class="invalid-feedback">
                        What's your role name?
                    </div>
                </div>
                <div class="form-group">
                    <label class="section-title mt-0">Permissions</label>



                    <div class="form-check">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="checkPermissionAll" value="1"  {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                          <label class="custom-control-label" for="checkPermissionAll">All</label>
                        </div>
                    </div>
                    <hr>
                    @php $i = 1; @endphp
                    @foreach ($permission_groups as $group)
                        <div class="row">

                            @php
                                $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                $j = 1;
                            @endphp

                            <div class="col-3">


                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="{{$i}}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{$i}}-management-checkbox', this)"  {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }} >
                                      <label class="custom-control-label" for="{{$i}}Management">{{ $group->name }}</label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-9 role-{{$i}}-management-checkbox">
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" name="permissions[]" id="customCheck{{$permission->id}}" onclick="checkSinglePermission('role-{{$i}}-management-checkbox', '{{$i}}Management', {{ count($permissions) }})"  value="{{$permission->name}}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} >
                                          <label class="custom-control-label" for="customCheck{{$permission->id}}">{{str_replace($group->name.".", "",$permission->name)}}</label>
                                        </div>
                                    </div>
                                    @php  $j++; @endphp
                                @endforeach
                                <br>
                            </div>

                        </div>
                        @php  $i++; @endphp
                    @endforeach

                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>

    </div>
  </div>
@endsection
@section('scripets')
  @include('backend.roles.partials.scripts')
@endsection
