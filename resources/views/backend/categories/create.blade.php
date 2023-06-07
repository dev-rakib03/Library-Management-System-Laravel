@extends('backend.layouts.app')
@section('title', 'Admin Create')
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
            <form class="needs-validation" novalidate="" action="{{route('categories.store')}}" method="POST">
                @csrf
            <div class="card-header">
                <h4>Create Category</h4>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Category or Sub-Category Name</label>
                        <input type="text" class="form-control" required="" name="cat_name">
                        <div class="invalid-feedback">
                            What's your category name?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Category Type</label>
                        <select name="cat_type" id="cat_type" class="form-control form-control-lg">
                                <option value="main" selected>Main</option>
                                <option value="sub">Sub</option>
                        </select>
                    </div>
                </div>

                <div class="form-row" id="m_f_s">

                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Category Status</label>
                        <select name="status" id="status" class="form-control form-control-lg">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
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


    $('#cat_type').on('change', function() {

        if( this.value =='sub'){
            document.getElementById("m_f_s").innerHTML =
                    '<div class="form-group col-md-6 col-sm-12">'+
                        '<label  class="section-title mt-0">Category</label>'+
                        '<select name="main_cat_id" id="main_cat_id" class="form-control select2" placeholder="-Select Category-">'+
                            '<option value="" selected>-Select Category-</option>'+

                            '@foreach ($categories as $cat)'+
                            '<option value="{{ $cat->id }}">{{ $cat->category_title }}</option>'+
                            '@endforeach'+

                        '</select>'+
                    '</div>'+
                    '<div class="form-group col-md-6 col-sm-12">'+
                        '<label  class="section-title mt-0">Category Status</label>'+
                        '<select name="status" id="status" class="form-control form-control-lg">'+
                                '<option value="1" selected>Active</option>'+
                                '<option value="0">Inactive</option>'+
                        '</select>'+
                    '</div>';
        }
        if( this.value =='main'){
            document.getElementById("m_f_s").innerHTML = '<div class="form-group col-md-6 col-sm-12">'+
                        '<label  class="section-title mt-0">Category Status</label>'+
                        '<select name="status" id="status" class="form-control form-control-lg">'+
                                '<option value="1" selected>Active</option>'+
                                '<option value="0">Inactive</option>'+
                        '</select>'+
                    '</div>';
        }
    });
</script>
@endsection
