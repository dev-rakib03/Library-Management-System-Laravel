<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\books;
use App\Models\categories;
use App\Models\sub_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $categories = categories::all();
        $sub_categories = sub_categories::all();

        return view('backend.categories.index', compact('categories','sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $categories  = categories::all();
        return view('backend.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        // Validation Data
        $request->validate([
            'cat_name' => 'required|max:50',
            'cat_type' => 'required',
            'status' => 'required',
        ]);

        if($request->cat_type=='main'){
            // Create New category
            $categories = new categories();
            $categories->category_title = $request->cat_name;
            $categories->status = $request->status;
            $categories->created_at = date('Y-m-d h:m:s');
            $categories->save();
            session()->flash('success', 'Category has been created !!');
        }
        else{
            $request->validate([
                'main_cat_id' => 'required',
            ]);
            // Create New sub-category
            $sub_categories = new sub_categories();
            $sub_categories->category_id = $request->main_cat_id;
            $sub_categories->subcategory_title = $request->cat_name;
            $sub_categories->status = $request->status;
            $sub_categories->created_at = date('Y-m-d h:m:s');
            $sub_categories->save();
            session()->flash('success', 'Sub-Category has been created !!');
        }
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }
        $type=substr($id, 0, 3);
        if($type=='cat'){
            $cat_id=str_replace("cat","",$id);
            $category=categories::where('id',$cat_id)->first();
            $categories  = categories::all();
            return view('backend.categories.edit', compact('category','categories','type'));
        }
        else if($type=='sub'){
            $sub_cat_id=str_replace("sub","",$id);
            $sub_categories=sub_categories::where('id',$sub_cat_id)->first();
            $categories  = categories::all();
            return view('backend.categories.edit', compact('sub_categories','categories','type'));
        }
        else{
            session()->flash('error', 'Somthing went wrong !!');
            return back();
        }
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
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        // Validation Data
        $request->validate([
            'cat_name' => 'required|max:50',
            'cat_type' => 'required',
            'status' => 'required',
        ]);

        if($request->cat_type=='main'){
            // Create New category
            $categories = categories::find($id);

            $categories->category_title = $request->cat_name;
            $categories->status = $request->status;
            $categories->created_at = date('Y-m-d h:m:s');
            $categories->save();
            session()->flash('success', 'Category has been updated !!');
        }
        else{
            $request->validate([
                'main_cat_id' => 'required',
            ]);
            // Create New sub-category
            $sub_categories =sub_categories::find($id);

            $sub_categories->category_id = $request->main_cat_id;
            $sub_categories->subcategory_title = $request->cat_name;
            $sub_categories->status = $request->status;
            $sub_categories->created_at = date('Y-m-d h:m:s');
            $sub_categories->save();
            session()->flash('success', 'Sub-Category has been updated !!');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any admin !');
        }

        $type=substr($id, 0, 3);
        if($type=='cat'){
            $cat_id=str_replace("cat","",$id);
            $sub_categories=sub_categories::where('category_id',$cat_id)->get();
            $category=categories::find($cat_id);
            if($sub_categories!=null){
                foreach($sub_categories as $subcat){
                    $book=books::where('sub_category_id',$subcat)->get();
                    if($book!=null){
                        session()->flash('error', 'At first delete all books of this category !!');
                        return back();
                    }
                }
                sub_categories::where('category_id',$cat_id)->delete();
                $category->delete();
            }
            else{
                $category->delete();
            }
            session()->flash('success', 'Category has been deleted !!');
            return back();
        }
        else if($type=='sub'){
            $sub_cat_id=str_replace("sub","",$id);
            $book=books::where('sub_category_id',$sub_cat_id)->get();
            if($book!=null){
                session()->flash('error', 'At first delete all books of this category !!');
                return back();
            }
            else{
                $sub_categories=sub_categories::find($sub_cat_id);
                $sub_categories->delete();
            }

            session()->flash('success', 'Sub-Category has been deleted !!');
            return back();
        }
        else{
            session()->flash('error', 'Somthing went wrong !!');
            return back();
        }
    }
}
