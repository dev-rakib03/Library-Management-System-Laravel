@extends('backend.layouts.app')
@section('title', 'Role Create')
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
            <form class="needs-validation" novalidate="" action="{{route('admin.roles.store')}}" method="POST">
                @csrf
            <div class="card-header">
                <h4>Create Role</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label  class="section-title mt-0">Role Name</label>
                    <input type="text" class="form-control" required="" name="name">
                    <div class="invalid-feedback">
                        What's your role name?
                    </div>
                </div>
                <div class="form-group">
                    <label class="section-title mt-0">Permissions</label>



                    <div class="form-check">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="checkPermissionAll" value="1">
                          <label class="custom-control-label" for="checkPermissionAll">All</label>
                        </div>
                    </div>
                    <hr>
                    @php $i = 1; @endphp
                    @foreach ($permission_groups as $group)
                        <div class="row">
                            <div class="col-3">


                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="{{$i}}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{$i}}-management-checkbox', this)" >
                                      <label class="custom-control-label" for="{{$i}}Management">{{ $group->name }}</label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-9 role-{{$i}}-management-checkbox">
                                @php
                                    $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                    $j = 1;
                                @endphp
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" name="permissions[]" id="customCheck{{$permission->id}}" onclick="checkSinglePermission('role-{{$i}}-management-checkbox', '{{$i}}Management', {{ count($permissions) }})"  value="{{$permission->name}}">
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
                <button class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>

    </div>
  </div>
@endsection
@section('scripets')
  @include('backend.roles.partials.scripts')
@endsection
