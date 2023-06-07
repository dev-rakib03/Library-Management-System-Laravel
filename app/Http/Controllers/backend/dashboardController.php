<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\books;
use App\Models\categories;
use App\Models\sub_categories;


class dashboardController extends Controller
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
        if (is_null($this->user)) {
            return redirect()->route('admin.login');
        }
        $books=books::all();
        $users=Admin::all();
        $categoreis=categories::all();
        $subcategoreis=sub_categories::all();

        $books_s=books::where('status',1)->orderBy('sub_category_id', 'ASC')->get();
        $categoreis_s=categories::where('status',1)->paginate(5);
        $subcategoreis_s=sub_categories::where('status',1)->get();

        return view('backend.dashboard.dashboard',compact('books','books_s','subcategoreis_s','categoreis_s','users','categoreis','subcategoreis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user)) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $books=books::all();
        $users=Admin::all();
        $categoreis=categories::all();
        $subcategoreis=sub_categories::all();

        if($request->search_book_name){
            $books_s=books::where('book_title', 'LIKE', "%$request->search_book_name%")->where('status',1)->paginate(40);
        }
        else{
            $books_s=books::where('sub_category_id', 'LIKE', "%$request->sub_category%")->where('status',1)->paginate(40);
        }

        $categoreis_s=categories::where('status',1)->get();
        $subcategoreis_s=sub_categories::where('status',1)->get();

        return view('backend.dashboard.dashboard',compact('books','books_s','subcategoreis_s','categoreis_s','users','categoreis','subcategoreis'));
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
