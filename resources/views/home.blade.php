@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <form action="{{route("upload")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photo" required>
                    <button type="submit">Submit</button>
                  </form>
                </div>

                <h1><center>Photo Preview</center></h1>
                @if(isset($photo_url))
                <a style="height:30px; width: 100px; margin: auto; background:lightblue; color:black; padding:2px" type="button" href="{{route("update",$photo_id)}}" >Update</a>
                <a style="height:30px; width: 100px; margin: auto; background:red; color:white; padding:2px" type="button" href="{{route("delete",$photo_id)}}" >Delete</a>
                <img style="height:400px; width:500px; margin:auto;"src="{{$photo_url}}" class="rounded" alt="{{$photo_url}}">
                @else
                <p>Sorry no photo to preview</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
