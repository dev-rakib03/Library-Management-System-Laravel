@extends('backend.layouts.app')
@section('title', 'Site Settings')
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
            <form class="needs-validation" novalidate="" action="{{route('settings.site.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="card-header">
                <h4>Site Settings</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label  class="section-title mt-0">Site Name</label>
                    <input type="text" class="form-control" required="" name="site_name" value="{{env('APP_NAME')}}">
                    <div class="invalid-feedback">
                        What's your site name?
                    </div>
                </div>
                <div class="form-group">
                    <label  class="section-title mt-0">Site Logo (png only)</label>
                    <input type="file" class="form-control" accept="image/png" name="site_logo">
                    <div class="invalid-feedback">
                        Upload site logo.
                    </div>
                </div>
                <div class="form-group">
                    <label  class="section-title mt-0">Site Favicon(1:1)(png only)</label>
                    <input type="file" class="form-control" accept="image/*" name="site_favicon">
                    <div class="invalid-feedback">
                        Upload site favicon.
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

@endsection
