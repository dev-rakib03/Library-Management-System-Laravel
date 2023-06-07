<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class settingsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('settings.site')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        return view('backend.settings.site');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('settings.site')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        // Validation Data
        $request->validate([
            'site_name' => 'required',
        ]);

        //$this->setEnv('APP_NAME', $request->site_name);
        $this->setEnvironmentValue('APP_NAME', preg_replace('/\s+/', '', $request->site_name));

        if($request->site_logo){
            // Validation Data
            $request->validate([
                'site_logo' => 'required|mimes:png',
            ]);
            //image upload
            $logo=$request->site_logo;
            // create new file name.
            $imageName = 'logo'.".".$logo->getClientOriginalExtension();
            $uploadPath = 'backend/assets/img/';
            $logo->move($uploadPath,$imageName);
        }

        if($request->site_favicon){
            // Validation Data
            $request->validate([
                'site_favicon' => 'required|mimes:ico|dimensions:ratio=1/1',
            ]);
            //image upload
            $favicon=$request->site_favicon;
            // create new file name.
            $fimageName = 'favicon'.".".$favicon->getClientOriginalExtension();
            $fuploadPath = 'backend/assets/img/';
            $favicon->move($fuploadPath,$fimageName);
        }

        return redirect()->route('admin.login');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
