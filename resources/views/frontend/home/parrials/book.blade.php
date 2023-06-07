
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header" style="display: block;">
                        <h4>{{$book->book_title}}</h4>
                        <p>
        
                                
                                        {{$cat->category_title}}>{{$subcat->subcategory_title}}
                                    
        
                        </p>
                    </div>
                    <div class="card-body">
                        <img class="d-block w-100" src="{{asset('/')}}{{$book->thum_path}}" alt="" style="height: 400px; object-fit:contain;border:1px solid rgb(207, 206, 206);">
                    </div>
                    <center>
                        <div class="buttons">
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-icon icon-left btn-info" target="_blank"><i class="fas fa-eye"></i> View</a>
                        </div>
                    </center>
                </div>
            </div>
            


