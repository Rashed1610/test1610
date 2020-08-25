@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <form action="{{route("update_post")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photo" required>
                    <input type="hidden" name="id" value="{{$id}}">
                    <button type="submit">Update</button>
                  </form>
                </div>

                <!-- <h1><center>Photo Preview</center></h1>
                @if(isset($photo_url))
                <img style="height:400px; width:500px; margin:auto;"src="{{$photo_url}}" class="rounded" alt="{{$photo_url}}">
                @else
                <p>Sorry no photo to preview</p>
                @endif -->
            </div>
        </div>
    </div>
</div>
@endsection
