@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        @if(count($yourcourses)>0)
            <h1 style="text-align: center;">Your Courses</h1>
            <div class="col-md-12">
                <div class="row">
                    @foreach($yourcourses as $yourcourse)
                        <div class="col-md-3">
                            {{-- <?php $module_first = $modules->firstWhere('course_id', $yourcourse->id); ?> --}}
                                @if(isset($yourcourse->thumbnail))
                                    <div  style="background-size: contain; background-image:url('/storage/{{$yourcourse->trainer}}/thumbnails/{{$yourcourse->thumbnail}}'); padding-top: 50%; background-repeat: no-repeat; background-position: center; background-color: black">
                                    </div>
                                @else
                            <img width="100%" src="/storage/thumbnails/no-image.png">
                                    
                                @endif
                            {{-- <img width="100%" src="/storage/selfie.png"> --}}
                            <h2><a href="prof/course/{{$yourcourse->id}}">{{$yourcourse->title}}</a></h2>
                            <h5>By: {{$yourcourse->trainer}}</h5>
                            <h6>About: {{$yourcourse->about}}</h6>
                            @foreach($yourcourse->users as $user)
                                @if($user->id == Auth::id())
                                    {{$user->name}}
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
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