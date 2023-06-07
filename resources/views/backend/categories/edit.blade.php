@extends('backend.layouts.app')
@section('title', 'Category Edit')
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
            <form class="needs-validation" novalidate="" action="{{route('categories.update',$type === "cat" ? $category->id : $sub_categories->id)}}" method="POST">
                @method('PUT')
                @csrf
            <div class="card-header">
                <h4>Edit Category</h4>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Category or Sub-Category Name</label>
                        <input type="text" class="form-control" required="" name="cat_name" value="{{$type === "cat" ? $category->category_title : $sub_categories->subcategory_title}}">
                        <div class="invalid-feedback">
                            What's your category name?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Category Type</label>
                        <select name="cat_type" id="cat_type" class="form-control form-control-lg">
                                <option value="main" {{$type === "cat" ? 'selected' : ''}} >Main</option>
                                <option value="sub" {{$type === "sub" ? 'selected' : ''}} >Sub</option>
                        </select>
                    </div>
                </div>

                @php
                    $select1='';
                    $select0='';

                    if ($type==='cat') {
                        if ( $category->status == 1) {
                            $select1='selected';
                        }
                        if ($category->status == 0) {
                            $select0='selected';
                        }
                    }
                    else {
                        if ($sub_categories->status == 1) {
                            $select1='selected';
                        }
                        if ($sub_categories->status == 0) {
                            $select0='selected';
                        }
                    }
                @endphp

                <div class="form-row" id="m_f_s">

                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Category Status</label>
                        <select name="status" id="status" class="form-control form-control-lg">
                                <option value="1" {{$select1}}>Active</option>
                                <option value="0" {{$select0}}>Inactive</option>
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

    function onload() {
        if( "{{$type}}" == "sub"){
            document.getElementById("m_f_s").innerHTML =
                    '<div class="form-group col-md-6 col-sm-12">'+
                        '<label  class="section-title mt-0">Category</label>'+
                        '<select name="main_cat_id" id="main_cat_id" class="form-control select2" placeholder="-Select Category-">'+

                            '@foreach ($categories as $cat)'+
                            '<option value="{{ $cat->id }}" {{$type === "sub" ? $sub_categories->category_id === $cat->id ? "selected" : "" : ""}}>{{ $cat->category_title }}</option>'+
                            '@endforeach'+

                        '</select>'+
                    '</div>'+
                    '<div class="form-group col-md-6 col-sm-12">'+
                        '<label  class="section-title mt-0">Category Status</label>'+
                        '<select name="status" id="status" class="form-control form-control-lg">'+
                                '<option value="1" {{$select1}} >Active</option>'+
                                '<option value="0" {{$select0}} >Inactive</option>'+
                        '</select>'+
                    '</div>';
        }
    }
    onload();

    $('#cat_type').on('change', function() {

        if( this.value =='sub'){
            onload();
        }
        if( this.value =='main'){
            document.getElementById("m_f_s").innerHTML = '<div class="form-group col-md-6 col-sm-12">'+
                        '<label  class="section-title mt-0">Category Status</label>'+
                        '<select name="status" id="status" class="form-control form-control-lg">'+
                            '<option value="1" {{$select1}} >Active</option>'+
                            '<option value="0" {{$select0}} >Inactive</option>'+
                        '</select>'+
                    '</div>';
        }
    });



</script>
@endsection
