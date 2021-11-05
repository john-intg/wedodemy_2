@extends('layouts.app')

@section('content')
    <div class="col-md-12 mb-30">
        <h1 style="text-align: center;">Available Courses</h1>
        <div class="col-md-12">
            <div class="row">
                @if(count($courses)>0)
                    @foreach($courses as $course)
                        <div class="col-md-3">
                            @if(isset($course->thumbnail))
                                <div  style="background-size: contain; background-image:url('/storage/{{$course->trainer}}/thumbnails/{{$course->thumbnail}}'); padding-top: 50%; background-repeat: no-repeat; background-position: center; background-color: black">
                                </div>
                            @else
                            <img width="100%" src="/storage/thumbnails/no-image.png">
                                    
                                @endif
                            {{-- <img width="100%" src="/storage/selfie.png"> --}}
                            <h2><a href="course/{{$course->id}}">{{$course->title}}</a></h2>
                            <h5>By: {{$course->trainer}}</h5>
                            <h6>About: {{$course->about}}</h6>
                            @foreach($course->users as $user)
                                @if($user->id == Auth::id())
                                    {{$user->name}}
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection