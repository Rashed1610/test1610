<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\photo;
use Image;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\File;
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
        $id = Auth::id();
        $photo = photo::whereuser_id($id)->first();
        if(is_null($photo))
        {
          return view('home');
        }
        else
        {
          $photo_name = $photo->photo;
          $photo_id = $photo->id;
          dd($photo_name);
          $photo_url = Storage::disk('dropbox')
          ->getDriver() // `\League\Flysystem\Flysystem` instance
          ->getAdapter() // `\Spatie\FlysystemDropbox\DropboxAdapter` instance
          ->getClient() // `\Spatie\Dropbox\Client` instance
          ->getTemporaryLink('Apps/Demo1610/'.$photo_name);
          //dd($photo_url);
           return view('home',compact('photo_url','photo_id'));
          //return view('home');
        }

     }

     public function upload(Request $request)
     {

             $file_src=$request->file("photo"); //file src
           //$is_file_uploaded = Storage::disk('dropbox')->put('public',$file_src);

           // if($is_file_uploaded){
           //   return Redirect::back()->withErrors(['msg'=>'Succesfuly file uploaded to dropbox']);
           // } else {
           //   return Redirect::back()->withErrors(['msg'=>'file failed to uploaded on dropbox']);
           // }

             $user_id = Auth::id();
             $last_inserted_id = photo::insertGetId([
               'user_id' => $user_id,
               'photo' =>$request-> photo,
            ]);
            if ($request->hasFile('photo')) {
             $photo_upload     =  $request ->photo;
             $photo_extension  =  $photo_upload -> getClientOriginalExtension();
             $photo_name       =  $user_id. "." . $photo_extension;
             // Image::make($photo_upload)->resize(360,360)->save(base_path('public/uploads/'.$photo_name),100);
             //Storage::disk('dropbox')->put('Apps/Demo1610',$photo_upload);
             Storage::disk('dropbox')->putFileAs('Apps/Demo1610', new File($photo_upload), $photo_name);;
             photo::findOrfail($last_inserted_id)->update([
             'photo'          => $photo_name,
           ]);
           }

          return back();

        dd($request->photo);
         //return back();
     }


     public function update($id)
     {
       return view('update',compact('id'));
     }



     public function update_post(Request $request)
     {

             $file_src=$request->file("photo"); //file src
           //$is_file_uploaded = Storage::disk('dropbox')->put('public',$file_src);

           // if($is_file_uploaded){
           //   return Redirect::back()->withErrors(['msg'=>'Succesfuly file uploaded to dropbox']);
           // } else {
           //   return Redirect::back()->withErrors(['msg'=>'file failed to uploaded on dropbox']);
           // }

             $user_id = Auth::id();
             photo::whereid($request->id)->update([
               'photo' =>$request-> photo,
            ]);
            if ($request->hasFile('photo')) {
             $photo_upload     =  $request ->photo;
             $photo_extension  =  $photo_upload -> getClientOriginalExtension();
             $photo_name       =  $user_id. "." . $photo_extension;
             // Image::make($photo_upload)->resize(360,360)->save(base_path('public/uploads/'.$photo_name),100);
             //Storage::disk('dropbox')->put('Apps/Demo1610',$photo_upload);
             Storage::disk('dropbox')->putFileAs('Apps/Demo1610', new File($photo_upload), $photo_name);;
             photo::findOrfail($request->id)->update([
             'photo'          => $photo_name,
           ]);
           }

          return redirect()->route('home');

     }


     public function delete($id)
   {
     $photo_name = photo::whereid($id)->first()->photo;
     photo::whereid($id)->delete();
     Storage::disk('dropbox')
     ->getDriver() // `\League\Flysystem\Flysystem` instance
     ->getAdapter() // `\Spatie\FlysystemDropbox\DropboxAdapter` instance
     ->getClient() // `\Spatie\Dropbox\Client` instance
     ->delete('Apps/Demo1610/'.$photo_name);
     return redirect()->route('home');
   }
}
