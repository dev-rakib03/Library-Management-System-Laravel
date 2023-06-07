@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px!important;
        text-align: center;
    }
    .select2 select2-container select2-container--default{
        width: 100%!important;
    }
    .cat-header,.subcat-header{
        background:#6777ef;
        border:2px solid gray;
        box-shadow:0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
        color:#fff;
        margin: 10px 0px;
        border-radius:15px;
        padding-top:8px;
    }
    .subcat-header{
        background:#354093;
        width:99%;
        margin-left:0.5%;
    }
</style>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <center>
                        <div style="margin: 5px 0px;">
                        <a href="/">
                            <img alt="image" src="{{asset('/')}}backend/assets/img/logo.png" class="header-logo" style="height: 40px; object-fit:contain;" />
                        </a>
                        </div>
                        </center>
                    </div>
                    <div class="col-md-5">
                        <div style="margin: 5px 0px;">
                        <form method="POST" action="{{route('home.store')}}">
                            @csrf
                            <select name="sub_category" id="roles" class="form-control select2" data-live-search="true" onchange="this.form.submit()">
                                <option value="" style="color: lightgray;" selected disabled hidden>Filter By Category</option>
                                @foreach ($categoreis_s as $cat)
                                    <optgroup label="{{ $cat->category_title }}">
                                        @php
                                            $flag=0;
                                        @endphp
                                        @foreach ($subcategoreis_s as $subcat)
                                            @if ($cat->id==$subcat->category_id)
                                                <option value="{{ $subcat->id }}">{{ $subcat->subcategory_title }}</option>
                                                @php
                                                    $flag++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($flag==0)
                                            <option value="" style="color: lightgray;">No Sub Category found</option>
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        </form>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div style="margin: 5px 0px;">
                        <form method="POST" action="{{route('home.store')}}">
                            @csrf
                            <div style="width: 100%; display:inline-flex;">
                              <input class="form-control" type="search" placeholder="Search" aria-label="Search with book name" name="search_book_name">
                              <button class="btn btn-primary" type="submit" style="position: relative;left: -10px;">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <center>
                            <div style="margin: 5px 0px;">
                            <a href="#" data-toggle="dropdown" class="" style="text-decoration:none;">
                                <img alt="image" src="{{asset('/')}}backend/assets/img/user.png" style="height: 40px; object-fit:cover; border-radius:50%;">
                                <span class="d-sm-none d-lg-inline-block"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="margin-top:13px; ">
                                <div class="dropdown-title">Hello {{Auth::guard('admin')->user()->name}}</div>
                                <div class="dropdown-divider"></div>

                                @if (!Auth::guard('admin')->user()->can('panel.hide'))
                                    <a href="{{ route('admin.dashboard.index') }}" class="dropdown-item has-icon">
                                        <i class="fas fa-tachometer-alt"></i>
                                        Dashboard
                                    </a>
                                @endif

                                <a href="{{ route('admin.logout.submit') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                Logout
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout.submit') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        
        @foreach ($categoreis_s as $cat)
            @php
                $book_cat = 0;
            @endphp
            @foreach ($books_s as $book)
                @php
                    if($book->restricted_roles){
                        $selected_roles = json_decode($book->restricted_roles);
                    }
                    else{
                        $selected_roles = [];
                    }
                @endphp
                @if(!Auth::guard('admin')->user()->hasRole($selected_roles))
                    @php
                        $book_cat_q = \App\Models\sub_categories::where('id', $book->sub_category_id)->first();
                        if($cat->id==$book_cat_q->category_id){$book_cat = $cat->id;}
                    @endphp
                @endif
            @endforeach
            @if($book_cat!=0)
                <div class="row cat-header">
                    <div class="col-md-12">
                        <h5>{{ $cat->category_title }}</h5>
                    </div>
                </div>
            @endif
            @foreach ($subcategoreis_s as $subcat)
                @php
                    $find_subcat = 0;
                @endphp
                @foreach ($books_s as $book)
                    @php
                        if($book->restricted_roles){
                            $selected_roles = json_decode($book->restricted_roles);
                        }
                        else{
                            $selected_roles = [];
                        }
                    @endphp
                    @if(!Auth::guard('admin')->user()->hasRole($selected_roles))
                        @php
                            if($subcat->id==$book->sub_category_id){$find_subcat = $subcat->id;}
                        @endphp
                    @endif
                @endforeach
                @if($find_subcat!=0)
                    @if ($cat->id==$subcat->category_id)
                        <div class="row subcat-header">
                            <div class="col-md-12">
                                <h5>{{ $subcat->subcategory_title }}</h5>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($books_s as $book)
                                @php
                                    if($book->restricted_roles){
                                        $selected_roles = json_decode($book->restricted_roles);
                                    }
                                    else{
                                        $selected_roles = [];
                                    }
                                @endphp
                                @if(!Auth::guard('admin')->user()->hasRole($selected_roles))
                                                
                                    @if ($book->status==1)
                                        @if ($subcat->id==$book->sub_category_id)
                                            @if ($cat->id==$subcat->category_id)
                                                @include('frontend.home.parrials.book')
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif  
                @endif
            @endforeach
        @endforeach
        
        @if (count($books_s)==0)
            <div class="card">
                <div class="card-body">
                    <center>
                        <span> No book found</span>
                    </center>
                </div>
            </div>
        @endif
        

        <div class="card">
            <div class="card-body">
                <ul class="pagination" style="justify-content: center;">
                <li class="page-item {{$books_s->onFirstPage()? 'disabled':''}}">
                    <a class="page-link" href="{{$books_s->previousPageUrl()}}" tabindex="-1">Previous</a>
                </li>
                <li class="page-item" {{$books_s->onFirstPage()? 'hidden':''}}><a class="page-link" href="{{$books_s->previousPageUrl()}}">{{$books_s->currentPage()-1}}</a></li>
                <li class="page-item active">
                    <a class="page-link" href="#">{{$books_s->currentPage()}} <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"  {{$books_s->onLastPage()? 'hidden':''}}><a class="page-link" href="{{$books_s->nextPageUrl()}}">{{$books_s->currentPage()+1}}</a></li>
                <li class="page-item {{$books_s->onLastPage()? 'disabled':''}}">
                    <a class="page-link" href="{{$books_s->nextPageUrl()}}">Next</a>
                </li>
                </ul>
            </div>
        </div>


    </section>
@endsection
@section('scripets')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>
@endsection
