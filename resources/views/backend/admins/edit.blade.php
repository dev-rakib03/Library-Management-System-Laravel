@extends('backend.layouts.app')
@section('title', 'Admin Edit')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
            <form class="needs-validation" novalidate="" action="{{route('admin.admins.update',$admin->id)}}" method="POST">
                @method('PUT')
                @csrf
            <div class="card-header">
                <h4>Edit User</h4>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Name</label>
                        <input type="text" class="form-control" required="" name="name" value="{{$admin->name}}">
                        <div class="invalid-feedback">
                            What's your name?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">User Name</label>
                        <input type="text" class="form-control" required="" name="username" value="{{$admin->username}}">
                        <div class="invalid-feedback">
                            What's your user name?
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Email</label>
                        <input type="text" class="form-control" required="" name="email" value="{{$admin->email}}">
                        <div class="invalid-feedback">
                            What's your admin email?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Password</label>
                        <input type="password" class="form-control" name="password">
                        <div class="invalid-feedback">
                            What's your password?
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                        <div class="invalid-feedback">
                            What's your password?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Assign Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection
