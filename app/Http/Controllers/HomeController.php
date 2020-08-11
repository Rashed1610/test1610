<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\photo;
use Image;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
     {
        $photo = photo::first();
         return view('home',compact('photo'));
     }

     public function upload(Request $request)
     {

             $last_inserted_id = Auth::id();
             photo::insert([
               'photo' =>$request-> photo,
            ]);

            if ($request->hasFile('photo')) {
             $photo_upload     =  $request ->photo;
             $photo_extension  =  $photo_upload -> getClientOriginalExtension();
             $photo_name       =  $last_inserted_id. "." . $photo_extension;
             Image::make($photo_upload)->resize(360,360)->save(base_path('public/uploads/'.$photo_name),100);

             photo::findOrfail($last_inserted_id)->update([
             'photo'          => $photo_name,
           ]);
           }

          return back();

        dd($request->photo);
         //return back();
     }
}
