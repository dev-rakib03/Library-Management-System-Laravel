@extends('backend.layouts.app')
@section('title', 'Book Create')
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
            <form class="needs-validation" novalidate="" enctype="multipart/form-data" action="{{route('books.store')}}" method="POST">
                @csrf
            <div class="card-header">
                <h4>Create Book</h4>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Book Name</label>
                        <input type="text" class="form-control" required="" name="book_name">
                        <div class="invalid-feedback">
                            What's your book name?
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label  class="section-title mt-0">Book Category</label>
                        <select name="sub_category" required="" id="roles" class="form-control select2">
                            <option value="" style="color: lightgray;">-select-</option>
                            @foreach ($categories as $cat)
                                <optgroup label="{{ $cat->category_title }}">
                                    @php
                                        $flag=0;
                                    @endphp
                                    @foreach ($sub_categories as $subcat)
                                        @if ($cat->id==$subcat->category_id)
                                            <option value="{{ $subcat->id }}">{{ $subcat->subcategory_title }}</option>
                                            @php
                                                $flag++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if ($flag==0)
                                        <!--<option value="" style="color: lightgray;">No Category found</option>-->
                                    @endif
                                </optgroup>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            What's your book category?
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3 col-sm-12">
                        <label  class="section-title mt-0">Book Status</label>
                        <select id="inputState" required="" class="form-control" name="book_status">
                            <option value="1" selected="">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <label  class="section-title mt-0">Book Cover</label>
                        <input type="file" class="form-control" required="" accept="image/*" name="book_cover">
                        <div class="invalid-feedback">
                            Upload a book cover?
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <label  class="section-title mt-0">Book File</label>
                        <input type="file" class="form-control" required=""  accept="application/pdf" name="book_file">
                        <div class="invalid-feedback">
                            Upload a book pdf?
                        </div>
                    </div>

                    <div class="form-group col-md-3 col-sm-12">
                        <label  class="section-title mt-0">Hide From Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Selete the role has restricted.
                        </div>
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
