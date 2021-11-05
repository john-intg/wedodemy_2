@extends('layouts.app')

@section('content')
@if(isset($approval))
    @if($approval->name == Auth::user()->name)
        @if($approval->isApproved)
            <div class="col-md-12">
                <div class="col-md-12">
                    <input type="hidden" id="moduleID" value="{{$firstModule->module_id}}">
                    <h1><b>{{$course->title}}</b></h1> <h4>By: {{$course->trainer}}</h4>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8" id="module_video" style="text-align: center; background-color: black; height: 600px" >
                            <video oncontextmenu="return false;" height='100%'  controls controlsList="nodownload">
                                <source src="/storage/{{$course->trainer}}/{{$course->id}}/{{$firstModule->module_video}}" type="video/mp4">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                        <div class="col-md-4 ">
{{-- Modules --}}
                            @if(count($modules)> 0)
                                <h3>Modules</h3>
                                @foreach($modules as $module)
                                    <?php 
                                        $prev = $module->where('module_id', '<', $module->module_id)->where('course_id', $module->course_id)->orderBy('module_id', 'desc')->first();
                                        $link = $user->where('module_id', $module->module_id)->first();
                                        

                                    ?>
                                        {{-- $nexts = $user->where('module_id', '<', $module->module_id)->where('module_id', $prev->module_id)->first();  --}}
                                    @if($module->module_id == $firstModule->module_id)
                                        <div type="button" class="alert alert-primary" role="alert" onclick="moduleFunction('{{$module->module_name}}', '{{$module->module_video}}','{{$module->module_id}}')">
                                            {{$module->module_name}} @if(is_null($prev)) @else {{$prev->module_id}} @endif
                                        </div>
                                    @elseif(isset($user))
                                        @isset($user->where('module_id', '<', $module->module_id)->where('module_id', $prev->module_id)->first()->pivot->link)
                                            <div type="button" class="alert alert-primary" role="alert" onclick="moduleFunction('{{$module->module_name}}', '{{$module->module_video}}','{{$module->module_id}}')">
                                                {{$module->module_name}} 
                                            </div>
                                        @else
                                            <div class="alert alert-dark" >
                                                {{$module->module_name}}
                                            </div>
                                        @endisset
                                    @else
                                    @endif

                                    {{-- Modal for assignment --}}
                                    <form action="submitAssignment" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal fade" id="assignmentModal{{$module->module_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Assignment</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6>{{$module->module_assignment}}</h6>
                                                        <input type="hidden" name="module_id" value="{{$module->module_id}}">
                                                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                                        @if(isset($link->pivot->link))
                                                            <input type="text" class="form-control" name="link" placeholder="place your link here" value="{{$link->pivot->link}}" disabled="">
                                                        @else
                                                        <input type="text" class="form-control" name="link" placeholder="place your link here">
                                                                                                                
                                                    </div>
                                                    <div class="modal-footer">
                                                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                                    <div class="alert alert-warning">
                                                            <label>Note: Once you submit your assignment, you can't update it anymore</label>
                                                        </div>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                            @endif {{-- (count($modules)> 0) --}}
{{-- End Modules --}}
{{-- Appointment --}}
                            @if(isset($user))
                                @isset($user->where('module_id', $lastModule->module_id)->last()->pivot->link)
                                    @if(count($allAppointment)>0)
                                        @if(count($allAppointment)==1)
                                            @if($firstAppointment->appointment_done && $firstAppointment->appointment_confirm)
                                                <div class="input-group mb-3 alert alert-primary">
                                                    <label class="input-group">Done first appointment</label>
                                                    <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                                </div>
                                                <form method="POST" action="appointment">
                                                    @csrf
                                                    <div class="input-group mb-3 alert alert-primary">
                                                        <label class="input-group">Set second appointment</label>
                                                        <input type="hidden" name="course_id" value="{{$course->id}}">
                                                        <input type="date" class="form-control" name="appointment_date">
                                                        <div class="input-group-append">
                                                            <button class="btn  btn-primary" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @elseif($firstAppointment->appointment_confirm)
                                                <div class="input-group mb-3 alert alert-warning">
                                                    <label class="input-group">First appointment confirmed</label>
                                                    <label class="input-group">Please be available on this date</label>
                                                    <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                                </div>
                                            @else
                                                <div class="input-group mb-3 alert alert-dark">
                                                    <label class="input-group">Please wait for confirmation</label>
                                                    <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                                </div>
                                            @endif
                                        @else
                                            @if($lastAppointment->appointment_done && $lastAppointment->appointment_confirm)
                                                <div class="input-group mb-3 alert alert-primary">
                                                    <label class="input-group">Done first appointment</label>
                                                    <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                                </div>
                                                <div class="input-group mb-3 alert alert-primary">
                                                    <label class="input-group">Done second appointment</label>
                                                    <input type="date" class="form-control" value="{{$lastAppointment->appointment_date}}" disabled>
                                                </div>
                                            @elseif($lastAppointment->appointment_confirm)
                                                <div class="input-group mb-3 alert alert-primary">
                                                    <label class="input-group">Done first appointment</label>
                                                    <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                                </div>
                                                <div class="input-group mb-3 alert alert-warning">
                                                    <label class="input-group">Second appointment confirmed</label>
                                                    <label class="input-group">Please be available on this date</label>
                                                    <input type="date" class="form-control" value="{{$lastAppointment->appointment_date}}" disabled>
                                                </div>
                                            @else
                                                <div class="input-group mb-3 alert alert-primary">
                                                    <label class="input-group">Done first appointment</label>
                                                    <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                                </div>
                                                <div class="input-group mb-3 alert alert-dark">
                                                    <label class="input-group">Please wait for second appointment confirmation</label>
                                                    <input type="date" class="form-control" value="{{$lastAppointment->appointment_date}}" disabled>
                                                </div>
                                            @endif
                                        @endif
                                        {{-- <div class="input-group mb-3 alert alert-dark">
                                            <label class="input-group">Waiting to approve</label>
                                            <input type="date" class="form-control" value="{{$firstAppointment->appointment_date}}" disabled>
                                        </div> --}}
                                    @else
                                        <form method="POST" action="appointment">
                                            @csrf
                                            <div class="input-group mb-3 alert alert-primary">
                                                <label class="input-group">Set appointment</label>
                                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                                <input type="date" class="form-control" name="appointment_date" min="today">
                                                <div class="input-group-append">
                                                    <button class="btn  btn-primary" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @else
                                    <div class="input-group mb-3 alert alert-dark">
                                        <label class="input-group">Set appointment</label>
                                        <input type="date" class="form-control" disabled>
                                        <div class="input-group-append">
                                            <button class="btn  btn-outline-secondary" type="button" disabled>Submit</button>
                                        </div>
                                    </div>
                                @endisset
                            @endif
{{-- End Appointment --}}
{{-- Exam --}}
                            @if(count($allAppointment)>1 && $lastAppointment->appointment_done)
                                <div class="alert alert-primary" type="button" onclick="location.href ='exam/{{$course->id}}'">
                                    Final examination
                                </div>
                            @else
                                <div class="alert alert-dark" >
                                    Final examination
                                </div>
                            @endif
{{-- End Exam --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4" id="module_name">
                            <h2>{{$firstModule->module_name}}</h2>
                        </div>
                        <div class="col-md-4" id="module_assignment">
                            <button type="button" class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#assignmentModal{{$firstModule->module_id}}">Proceed to Assignment</button>
                        </div>
                            
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>    
            </div>
        @else {{-- ($approval->isApproved) --}}
{{-- Waiting to approve --}}
            <div class="col-md-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header" style="text-align: center;"><h3><b>{{$course->title}}</b></h3> By: {{$course->trainer}} </div>

                                <div class="card-body">
                                    @if(isset($firstModule->module_video)) 
                                        <video width="100%">
                                            <source src="/storage/{{$course->trainer}}/{{$course->id}}/{{$firstModule->module_video}}" type="video/mp4">

                                        </video>
                                    @else
                                        <img width="100%" src="/storage/thumbnails/no-image.png">
                                    @endif
                                    <div style="text-align: center;">
                                        <form method="post" action="storeRequest">
                                            @csrf
                                            <input type="hidden" name="student" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="course" value="{{$course->id}}">
                                            <h3>Waiting for approval</h3>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
{{-- End of waiting to approve --}}
    @else {{-- ($approval->name == Auth::user()->name) --}}
{{-- Not yet enrolled / view course --}}
        <div class="col-md-12">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header" style="text-align: center;"><h3><b>{{$course->title}}</b></h3> By: {{$course->trainer}} </div>

                            <div class="card-body">
                                @if(isset($firstModule->module_video)) 
                                    <video width="100%">
                                        <source src="/storage/{{$course->trainer}}/{{$course->id}}/{{$firstModule->module_video}}" type="video/mp4">

                                    </video>
                                @else
                                    <img width="100%" src="/storage/thumbnails/no-image.png">
                                @endif
                                {{$course->about}}
                                <div style="text-align: center;">
                                    <form method="post" action="storeRequest">
                                        @csrf
                                        <input type="hidden" name="student" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="course" value="{{$course->id}}">
                                        @if(isset(Auth::user()->email_verified_at))
                                            <button class="btn btn-primary">Enroll Now!!</button>
                                        @else
                                            Please Verify your Email!
                                        @endif
                                        {{$approval->name}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{-- end of not yet enrolled / view course --}}
    @endif {{-- ($approval->name == Auth::user()->name) --}}
@else {{-- (isset($approval)) --}}
    <div class="col-md-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header" style="text-align: center;"><h3><b>{{$course->title}}</b></h3> By: {{$course->trainer}} </div>

                        <div class="card-body">
                            @if(isset($firstModule->module_video)) 
                                <video width="100%">
                                    <source src="/storage/{{$course->trainer}}/{{$course->id}}/{{$firstModule->module_video}}" type="video/mp4">

                                </video>
                            @else
                                <img width="100%" src="/storage/thumbnails/no-image.png">
                            @endif
                            {{$course->about}}
                            <div style="text-align: center;">
                                <form method="post" action="storeRequest">
                                    @csrf
                                    <input type="hidden" name="student" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="course" value="{{$course->id}}">
                                    @if(isset(Auth::user()->email_verified_at))
                                        <button class="btn btn-primary">Enroll Now!!</button>
                                    @else
                                        Please Verify your Email!
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif {{-- (isset($approval)) --}}

{{-- Modal for add module --}}
<form action="addModule" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="assignmentModal{{$firstModule->module_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>{{$firstModule->module_assignment}}</h6>
                    <input type="text" class="form-control" name="" placeholder="place your link here">
                    <label>Note: Once you submit your assignment, you can't update it anymore</label>
                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- end of Modal for add module --}}
<script type="text/javascript">
    function moduleFunction(module_name, module_video, module_id){
        if (document.getElementById('moduleID').value != module_id) {
            document.getElementById('module_name').innerHTML = "<h2>"+module_name+"</h2>";
            document.getElementById('module_video').innerHTML = "<video width='100%' oncontextmenu='return false;' height='100%'  controls controlsList='nodownload'><source src='/storage/{{$course->trainer}}/{{$course->id}}/"+module_video+"' type='video/mp4'></video>";
            document.getElementById('module_assignment').innerHTML = ` <button type="button" class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#assignmentModal`+module_id+`">Proceed to Quiz</button>`;
            document.getElementById('moduleID').value = module_id;
        }
    }
</script>

@endsection