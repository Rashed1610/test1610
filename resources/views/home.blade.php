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
                    <input type="file" name="photo" >
                    <button class="btn btn-primary" type="submit">Upload</button>
                  </form>
                </div>

                <h1><center>Photo Preview</center></h1>
                @if(isset($photo))
                <img style="height:300px; width:300px; margin:auto;"src="{{ asset('uploads') }}/{{ $photo->photo}}" class="rounded" alt="{{$photo}}">
                @else
                <p>Sorry no photo to preview</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
