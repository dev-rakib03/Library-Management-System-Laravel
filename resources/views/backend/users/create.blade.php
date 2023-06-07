@extends('backend.layouts.app')
@section('title', 'User Create')
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
            <form class="needs-validation" novalidate="" action="{{route('admin.users.store')}}" method="POST">
                @csrf
            <div class="card-header">
                <h4>Create User</h4>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Name</label>
                        <input type="text" class="form-control" required="" name="name">
                        <div class="invalid-feedback">
                            What's your name?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Email</label>
                        <input type="text" class="form-control" required="" name="email">
                        <div class="invalid-feedback">
                            What's your user email?
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Password</label>
                        <input type="password" class="form-control" required="" name="password">
                        <div class="invalid-feedback">
                            What's your password?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Confirm Password</label>
                        <input type="password" class="form-control" required="" name="password_confirmation">
                        <div class="invalid-feedback">
                            What's your password?
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Assign Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection
