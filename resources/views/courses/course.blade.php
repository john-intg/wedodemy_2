@extends('layouts.app')

@section('content')
<script>
    function moduleFunction(module_name, module_video, module_assignment, module_id) {
        if (document.getElementById('moduleID').value != module_id) {
            document.getElementById('module_name').innerHTML = "<h2>"+module_name+"</h2>";
            document.getElementById('module_video').innerHTML = "<video oncontextmenu='return false;' height='100%' width='100%' controlsList='nodownload' controls=''><source src='/storage/{{$course->trainer}}/{{$course->id}}/"+module_video+"' type='video/mp4'></video>";
            document.getElementById('module_assignment').innerHTML = "<h4>"+module_assignment+"</h4>";
            document.getElementById('moduleID').value = module_id;

        }else{
        }
    }

    function confirmFunction(module_id){
        if (confirm("Are you sure?")) {
            location.href='deleteModule/'+module_id;
        }
    }
</script>
    <div class="col-md-12">
        <div class="col-md-12">
            @if(count($modules)>0)
                <input type="hidden" id="moduleID" value="{{$first_module->module_id}}">
            @endif
            <h1><b>{{$course->title}}</b></h1> <h4>{{$course->trainer}}</h4>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8" id="module_video" style="text-align: center; background-color: black; height: 600px" >
                    {{-- <iframe src="/storage/{{$course->trainer}}/{{$course->id}}/{{$first_module->module_video}}"></iframe> --}}
                   
                    <video oncontextmenu="return false;" height='100%'  controls controlsList="nodownload">
                        @if(count($modules) > 0)
                            <source src="/storage/{{$course->trainer}}/{{$course->id}}/{{$first_module->module_video}}" type='video/mp4'>
                            Your browser does not support HTML video.
                        @endif
                    </video>
                </div>
                <div class="col-md-4 ">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Modules</h3>
                        </div>
                        <!-- Button trigger modal -->
                        <div class="col-md-6" style="padding-bottom: 20px">
                            <button data-toggle="modal" data-target="#AddModuleModal" class="btn btn-success" style="float: right;">Add Modules</button>
                        </div>
                    </div>
                    
                    @if(count($modules) > 0)
                    <?php $module_counter = 1; ?>
                        @foreach($modules as $module)
                            @if($module->course_id == $course->id)
                            <?php $module_name = $module->module_name?>
                            <div type="button" @if(is_null($module->module_assignment)) class="form-control alert alert-danger" @endif class="form-control alert alert-primary" onclick="moduleFunction('{{$module_name}}', '{{$module->module_video}}','{{$module->module_assignment}}','{{$module->module_id}}')" style="height: 45px">
                                <label type="button" > Module {{$module_counter}} - {{$module_name}}</label>
                                
                                     <i type="button" class="fa fa-trash" style="font-size:150%; float: right;" onclick="confirmFunction('{{$module->module_id}}')">
                                        {{-- <form action="deleteModule" method="post">
                                            @csrf
                                            <input type="" name="module_id" value="{{$module->module_id}}">
                                            <button type="submit" ></button>
                                        </form> --}}
                                     </i>
                                     <i type="button" data-toggle="modal" data-target="#EditModuleModal{{$module->module_id}}" class="fa fa-edit" style="font-size:150%; float: right;padding-right: 10px"></i>

                               {{--  <a style="font-size:150%; float: right;" href="sss">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a style="font-size:150%; float: right; padding-right: 10px" href="sss">
                                    <i class="fa fa-edit"></i>
                                </a> --}}


                            </div>
                            <?php $module_counter++; ?>
                            @endif

                            {{-- Edit Modal --}}
                            <form action="editModule" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal fade" id="EditModuleModal{{$module->module_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Module</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="text" class="form-control" value="{{$module->module_name}}" name="updateModuleName" placeholder="Update Module Name">
                                        <textarea class="form-control" name="updateModuleAssignment" placeholder="Update the Instruction of assignment"> {{$module->module_assignment}} </textarea>
                                        <input type="file" class="form-control" id="updateModuleVideo" name="updateModuleVideo">
                                        <input type="hidden" value="{{$module->module_id}}" name="updateModuleId">
                                        <input type="hidden" name="course_trainer" value="{{$course->trainer}}">
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        @endforeach
                    @else
                        <h5>No Modules yet</h5>
                    @endif
                    @if(count($questions) > 0)
                        <div class="form-control alert alert-warning" onclick="location.href = 'exam/'+{{$course->id}}" style="height: 45px">
                            Edit Exam
                        </div>
                    @else
                        <div type="button" class="form-control alert alert-warning" onclick="location.href = 'exam/'+{{$course->id}}" style="height: 45px">
                            Add Exam
                        </div>
                    @endif                        
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                     @if(count($modules) > 0)
                     <div id="module_name">
                        <h2>{{$first_module->module_name}}</h2>
                     </div>
                    @endif
                </div>
                <div class="col-md-4">
                   {{--  @if(count($modules)>0)
                        @foreach($modules as $module)
                            <button type="button" class="btn btn-success" style="float: right;" onclick="confirm('{{$module->module_assignment}}')">View Assignment</button>
                        @endforeach
                    @endif --}}
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <hr>
        <div class="col-md-12" id="module_assignment">
            @if(count($modules)>0)
                <h4>{{$first_module->module_assignment}}</h4>
            @endif
        </div>
    </div>

    {{-- This is for modal --}}
    


<!--Add Modal -->
<form action="addModule" method="post" enctype="multipart/form-data">
    @csrf
<div class="modal fade" id="AddModuleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Module</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" name="module_name" placeholder="Module Name">
        <textarea class="form-control" name="module_assignment" placeholder="Instruction of assignment">
            
        </textarea>
        <input type="file" class="form-control" name="module">
        <input type="hidden" name="course_id" value="{{$course->id}}">
        <input type="hidden" name="course_trainer" value="{{$course->trainer}}">

      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
        <button type="submit" class="btn btn-primary">Add module</button>
      </div>
    </div>
  </div>
</div>
</form>


@endsection
    



        {{-- <div class="col-md-12">
            <h1><b>Course Title 1</b></h1> <h4>By Trainer</h4>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <video width="100%" controls="">
                        <source src="/storage/videos/1_4.MP4" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-md-4 ">
                    <h3>Modules</h3>
                    <div class="alert alert-primary" role="alert" >
                      <a href="">Module 1 - Module Title</a>
                    </div>
                    <div class="alert alert-dark" role="alert">
                      <a>Module 3 - Module Title</a>
                    </div><div class="alert alert-dark" role="alert">
                      <a>Module 4 - Module Title</a>
                    </div><div class="alert alert-dark" role="alert">
                      <a>Module 5- Module Title</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h2>Module 2 title</h2>
                    <h6>About this module</h6>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-success" style="float: right;">Proceed to Quiz</button>
                </div>
                    
                <div class="col-md-4">
                    

                </div>
            </div>
        </div> --}}
            
            
            

            
