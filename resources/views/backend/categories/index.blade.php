@extends('backend.layouts.app')
@section('title', 'All Category')
@section('css')
<link rel="stylesheet" href="{{asset('/')}}backend/assets/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{asset('/')}}backend/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>All Category</h4>
          @if (Auth::guard('admin')->user()->can('categories.create'))
          <div class="card-header-action">
            <a href="{{route('categories.create')}}" class="btn btn-primary">Add Category</a>
          </div>
          @endif
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                  <th>Serial</th>
                  <th>Category Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($categories as $cat)
                    <tr>
                        <td>
                        {{$loop->index+1}}
                        </td>
                        <td>{{ucfirst($cat->category_title)}}</td>
                        <td class="align-middle" style="">
                            @if ($cat->status==1)
                                <div class="badge badge-success badge-shadow" style="margin-bottom: 5px;">Active</div>
                            @endif
                            @if ($cat->status==0)
                                <div class="badge badge-danger badge-shadow" style="margin-bottom: 5px;">Inactive</div>
                            @endif
                        </td>
                        <td>
                            @if (Auth::guard('admin')->user()->can('categories.edit'))
                                <a href="{{ route('categories.edit', 'cat'.$cat->id) }}" class="btn btn-primary">Edit</a>
                            @endif
                            @if (Auth::guard('admin')->user()->can('categories.delete'))
                                <a class="btn btn-danger" href="#"
                                    onclick="Conform_Delete('{{$cat->id}}')">
                                    Delete
                                </a>

                                <form id="delete-form-{{ $cat->id }}" action="{{ route('categories.destroy', 'cat'.$cat->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endif
                        </td>
                    </tr>
                    @php
                        $ii=1;
                    @endphp
                    @foreach ($sub_categories as $sub_cat)
                        @if ($sub_cat->category_id==$cat->id)
                            <tr>
                                <td>
                                {{$cat->category_title}}->{{$ii++}}
                                </td>
                                <td>{{ucfirst($sub_cat->subcategory_title)}}</td>
                                <td class="align-middle" style="">
                                    @if ($sub_cat->status==1)
                                        <div class="badge badge-success badge-shadow" style="margin-bottom: 5px;">Active</div>
                                    @endif
                                    @if ($sub_cat->status==0)
                                        <div class="badge badge-danger badge-shadow" style="margin-bottom: 5px;">Inactive</div>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::guard('admin')->user()->can('categories.edit'))
                                        <a href="{{ route('categories.edit', 'sub'.$sub_cat->id) }}" class="btn btn-primary">Edit</a>
                                    @endif
                                    @if (Auth::guard('admin')->user()->can('categories.delete'))
                                        <a class="btn btn-danger" href="#"
                                            onclick="Conform_Delete('{{$sub_cat->id}}')">
                                            Delete
                                        </a>

                                        <form id="delete-form-sub-{{ $sub_cat->id }}" action="{{ route('categories.destroy', 'sub'.$sub_cat->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endif
                                    <script>
                                        function Conform_Delete(r_id)
                                        {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire(
                                                    'Deleted!',
                                                    'Your file has been deleted.',
                                                    'success'
                                                    )
                                                    event.preventDefault();
                                                    document.getElementById('delete-form-'+r_id).submit();
                                                }
                                            })
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('scripets')
<!-- JS Libraies -->
<script src="{{asset('/')}}backend/assets/bundles/datatables/datatables.min.js"></script>
<script src="{{asset('/')}}backend/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/')}}backend/assets/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{asset('/')}}backend/assets/js/page/datatables.js"></script>
@endsection
