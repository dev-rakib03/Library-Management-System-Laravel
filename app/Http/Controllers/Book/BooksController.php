<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\books;
use App\Models\categories;
use App\Models\sub_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class BooksController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('books.view')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $books = books::get();
        $categories = categories::get();
        $sub_categories=sub_categories::get();
        return view('backend.books.index', compact('books','categories','sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('books.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $categories=categories::all();
        $sub_categories=sub_categories::all();
        $roles  = Role::all();
        return view('backend.books.create', compact('categories','sub_categories','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('books.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        // Validation Data
        $request->validate([
            'book_name' => 'required',
            'sub_category' => 'required',
            'book_status' => 'required',
            'book_cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'book_file' => 'required|mimes:pdf',
        ]);

        //image upload
        $thum=$request->book_cover;
        // extract file name ..
        $fileName = pathinfo($thum->getClientOriginalName(), PATHINFO_FILENAME);
        // extract extenstion
        $extension = pathinfo($thum->getClientOriginalName(), PATHINFO_EXTENSION);
        // create new file name.
        $imageName = time().".".$thum->getClientOriginalExtension();
        $uploadPath = 'uploads/bookscover/';
        $thum->move($uploadPath,$imageName);
        $image_path = $uploadPath.$imageName;


         //pdf upload
         $pdf=$request->book_file;
         // extract file name ..
         $pdffileName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
         // extract extenstion
         $pdfextension = pathinfo($pdf->getClientOriginalName(), PATHINFO_EXTENSION);
         // create new file name.
         $pdfName = time().".".$pdf->getClientOriginalExtension();
         $pdfuploadPath = 'uploads/books/';
         $pdf->move($pdfuploadPath,$pdfName);
         $file_path = $pdfuploadPath.$pdfName;


        // Create New book
        $book = new books();
        $book->book_title = $request->book_name;
        $book->sub_category_id = $request->sub_category;
        $book->status = $request->book_status;
        $book->thum_path = $image_path;
        $book->file_path = $file_path;
        if($request->roles){
           $book->restricted_roles = json_encode($request->roles); 
        }
        $book->save();

        session()->flash('success', 'Book has been created !!');
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_null($this->user) || !$this->user->can('books.show')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $book=books::where('id',$id)->first();
        if($book->restricted_roles){
            $selected_roles = json_decode($book->restricted_roles);
        }
        else{
            $selected_roles = [];
        }
        if (Auth::guard('admin')->user()->hasRole($selected_roles)) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }
        return view('backend.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('books.edit')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $categories=categories::all();
        $sub_categories=sub_categories::all();
        $book=books::where('id',$id)->first();
        $roles  = Role::all();
        return view('backend.books.edit', compact('categories', 'sub_categories','book','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('books.edit')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $book = books::find($id);
        $book_details = books::where('id',$id)->first();

        // Validation Data
        $request->validate([
            'book_name' => 'required',
            'sub_category' => 'required',
            'book_status' => 'required',
        ]);

        if($request->book_cover!=null){
            $request->validate([
                'book_cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if (File::exists(public_path($book_details->thum_path))) {
                File::delete(public_path($book_details->thum_path));
            }
            //image upload
            $thum=$request->book_cover;
            // extract file name ..
            $fileName = pathinfo($thum->getClientOriginalName(), PATHINFO_FILENAME);
            // extract extenstion
            $extension = pathinfo($thum->getClientOriginalName(), PATHINFO_EXTENSION);
            // create new file name.
            $imageName = time().".".$thum->getClientOriginalExtension();
            $uploadPath = 'uploads/bookscover/';
            $thum->move($uploadPath,$imageName);
            $image_path = $uploadPath.$imageName;
            $book->thum_path = $image_path;
        }

        if($request->book_file!=null){
            $request->validate([
                'book_file' => 'required|mimes:pdf',
            ]);
            if (File::exists(public_path($book_details->file_path))) {
                File::delete(public_path($book_details->file_path));
            }
            //pdf upload
            $pdf=$request->book_file;
            // extract file name ..
            $pdffileName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
            // extract extenstion
            $pdfextension = pathinfo($pdf->getClientOriginalName(), PATHINFO_EXTENSION);
            // create new file name.
            $pdfName = time().".".$pdf->getClientOriginalExtension();
            $pdfuploadPath = 'uploads/books/';
            $pdf->move($pdfuploadPath,$pdfName);
            $file_path = $pdfuploadPath.$pdfName;
            $book->file_path = $file_path;
        }


        // Create New book

        $book->book_title = $request->book_name;
        $book->sub_category_id = $request->sub_category;
        $book->status = $request->book_status;
        if($request->roles){
           $book->restricted_roles = json_encode($request->roles); 
        }else{
            $book->restricted_roles = null; 
        }
        $book->save();

        session()->flash('success', 'Book has been updated !!');
        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('books.delete')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $book = books::find($id);
        $book_details = books::where('id',$id)->first();
        if (File::exists(public_path($book_details->thum_path))) {
            File::delete(public_path($book_details->thum_path));
        }
        if (File::exists(public_path($book_details->file_path))) {
            File::delete(public_path($book_details->file_path));
        }
        if (!is_null($book)) {
            $book->delete();
        }
        session()->flash('success', 'Admin has been deleted !!');
        return back();
    }
}
