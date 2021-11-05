@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9 col-sm-9">
                                <h1>My Courses</h1>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type="button" data-toggle='modal' data-target="#AddCourseModal" style="float: right;" class="btn btn-success">Add Course</button>
                            </div>
                        </div>
                        @if(count($courses)>0)
                            <table class="table">
                                <tr>
                                    <th>Course Video</th>
                                    <th>Course Detail</th>
                                </tr>
                                @foreach($courses as $course)
                                    <tr>
                                        <td width="50%">
                                            <?php $module_first = $modules->firstWhere('course_id', $course->id); ?>
                                            @if(isset($course->thumbnail))
                                                <div  style="background-size: contain; background-image:url('/storage/{{$course->trainer}}/thumbnails/{{$course->thumbnail}}'); padding-top: 54%; background-repeat: no-repeat; background-position: center; background-color: black">
                                                    
                                                </div>
                                                {{-- <iframe src="/storage/{{$course->trainer}}/thumbnails/{{$course->thumbnail}}" width="100%" height="100%" scrolling="no" frameborder="0">
                                                    <img width="100%" src="/storage/thumbnails/no-image.png"> 
                                                    <video width="100%">
                                                        <source src="/storage/{{$course->trainer}}/{{$course->id}}/{{$module_first->module_video}}" type="video/mp4">
                                                        Your browser does not support HTML video.
                                                    </video>
                                                </iframe> --}}
                                            @else
                                                <img width="100%" src="/storage/thumbnails/no-image.png"> 
                                            @endif
                                        </td>
                                        <td>
                                            <h3><a href="course/{{$course->id}}">{{$course->title}}</a></h3>
                                            <h5>By: {{$course->trainer}}</h5>
                                            <h6>About: {{$course->about}}</h6>
                                            <button class="btn btn-success" type="button" data-toggle='modal' data-target="#EditCourseModal{{$course->id}}">Edit</button>
                                            {{-- onclick="location.href='course/editCourse/'+{{$course->id}}" --}}
                                            <button class="btn btn-danger" onclick="deleteCourse('{{$course->id}}','{{$course->title}}')">Delete</button>
                                            @if($course->publish)
                                                <form style="display: inline-block;" action="unpublish" method="POST" id="unpublish">
                                                    @csrf
                                                    <input type="hidden" value="{{$course->id}}" name="id">
                                                    <input type="hidden" value="0" name="publish">
                                                    <button type="submit" class="btn btn-warning">Unpublish</button>
                                                </form>
                                            @else
                                                <form style="display: inline-block;" action="publish" method="POST" id="publish">
                                                    @csrf
                                                    <input type="hidden" value="{{$course->id}}" name="id">
                                                    <input type="hidden" value="1" name="publish">
                                                    <button type="submit" class="btn btn-primary">Publish</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Edit Course Modal --}}
                                    <form action="update" method="post">
                                        @csrf
                                        <div class="modal fade" id="EditCourseModal{{$course->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" value="{{$course->id}}" name="id">
                                                        <input class="form-control" type="text" name="title" placeholder="Course Title" value="{{$course->title}}">
                                                        <textarea class="form-control" name="about" placeholder="About Course">{{$course->about}}
                                                        </textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Edit Course</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                            </table>
                        @else
                            Add course    
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- add Course Modal --}}
<form action="store" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="AddCourseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" name="title" placeholder="Course Title">
                    <input type="hidden" value="{{Auth::id()}}" name="user_id">
                    <input class="form-control" type="hidden" value="{{Auth::user()->name}}" name="trainer" placeholder="Course Trainer">
                    <textarea class="form-control" name="about" placeholder="About Course">
                    </textarea>
                    <input type="file" class="form-control" name="thumbnail">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </div>
            </div>
        </div>
    </div>
</form>




<script>
    function deleteCourse(id, title) {
        if (confirm('Do you want to delete '+ title+'?')) {
            location.href='/prof/course/deleteCourse/'+id;
        }
    }

</script>
@endsection