@extends('backend.layouts.app')
@section('title', 'All Books')
@section('css')
<link rel="stylesheet" href="{{asset('/')}}backend/assets/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{asset('/')}}backend/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>All Books</h4>
          @if (Auth::guard('admin')->user()->can('admin.create'))
          <div class="card-header-action">
            <a href="{{route('books.create')}}" class="btn btn-primary">Add Book</a>
          </div>
          @endif
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                  <th>Serial</th>
                  <th>Book Name</th>
                  <th>Category</th>
                  @if (Auth::guard('admin')->user()->can('books.adminview'))
                  <th>Status</th>
                  @endif
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($books as $book)
                    @php
                        if($book->restricted_roles){
                            $selected_roles = json_decode($book->restricted_roles);
                        }
                        else{
                            $selected_roles = [];
                        }
                    @endphp
                    
                    @if ($book->status==0 || Auth::guard('admin')->user()->can('books.adminview'))
                            <tr>
                                <td>
                                  {{$loop->index+1}}
                                </td>
                                <td>{{ucfirst($book->book_title)}}</td>
                                <td>
                                    @foreach ($sub_categories as $sub_cat)
                                        @if($book->sub_category_id==$sub_cat->id)
                                            @foreach ($categories as $cat)
                                                @if($sub_cat->category_id==$cat->id)
                                                    {{$cat->category_title}}>{{$sub_cat->subcategory_title}}
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                @if (Auth::guard('admin')->user()->can('books.adminview'))
                                <td class="align-middle" style="">
                                    @if ($book->status==1)
                                        <div class="badge badge-success badge-shadow" style="margin-bottom: 5px;">Active</div>
                                    @endif
                                    @if ($book->status==0)
                                        <div class="badge badge-danger badge-shadow" style="margin-bottom: 5px;">Inactive</div>
                                    @endif
                                </td>
                                @endif
                                <td>
                                    @if (Auth::guard('admin')->user()->can('books.view'))
                                        <a href="{{ route('books.show', $book->id) }}" target="_blank" class="btn btn-success">View</a>
                                    @endif
                                    @if (Auth::guard('admin')->user()->can('books.edit'))
                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit</a>
                                    @endif
                                    @if (Auth::guard('admin')->user()->can('books.delete'))
                                        <a class="btn btn-danger" href="{{ route('books.destroy', $book->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $book->id }}').submit();">
                                            Delete
                                        </a>
            
                                        <form id="delete-form-{{ $book->id }}" action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endif
                                </td>
                            </tr>
                    @else
                        @if(!Auth::guard('admin')->user()->hasRole($selected_roles))
                            <tr>
                            <td>
                              {{$loop->index+1}}
                            </td>
                            <td>{{ucfirst($book->book_title)}}</td>
                            <td>
                                @foreach ($sub_categories as $sub_cat)
                                    @if($book->sub_category_id==$sub_cat->id)
                                        @foreach ($categories as $cat)
                                            @if($sub_cat->category_id==$cat->id)
                                                {{$cat->category_title}}>{{$sub_cat->subcategory_title}}
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                            @if (Auth::guard('admin')->user()->can('books.adminview'))
                            <td class="align-middle" style="">
                                @if ($book->status==1)
                                    <div class="badge badge-success badge-shadow" style="margin-bottom: 5px;">Active</div>
                                @endif
                                @if ($book->status==0)
                                    <div class="badge badge-danger badge-shadow" style="margin-bottom: 5px;">Inactive</div>
                                @endif
                            </td>
                            @endif
                            <td>
                                @if (Auth::guard('admin')->user()->can('books.view'))
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-success">View</a>
                                @endif
                                @if (Auth::guard('admin')->user()->can('books.edit'))
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit</a>
                                @endif
                                @if (Auth::guard('admin')->user()->can('books.delete'))
                                    <a class="btn btn-danger" href="#"
                                        onclick="Conform_Delete('{{$book->id}}')">
                                        Delete
                                    </a>
        
                                    <form id="delete-form-{{ $book->id }}" action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: none;">
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
                    @endif
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
