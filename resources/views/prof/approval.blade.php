@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Requests for your approval</div>

                <div class="card-body">
                    @if(count($course_requests)> 0)
                        <table class="table">
                            <tr>
                                <th>
                                    Course title
                                </th>
                                <th>
                                    Requester
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            @foreach($course_requests as $request)
                                <tr>
                                    <td>
                                        {{$request->title}}
                                    </td>
                                    <td>
                                        {{$request->name}}
                                    </td>
                                    <td>
                                        <form method="POST" action="acceptEnrolee" style="display: inline-block;">
                                            @csrf
                                            <input type="hidden" value="{{$request->student_id}}" name="student_id">
                                            <input type="hidden" value="{{$request->course_id}}" name="course_id">

                                            <button class="btn btn-success">Accept</button>
                                        </form>
                                        <form method="POST" action="declineEnrolee" style="display: inline-block;">
                                            @csrf
                                            <input type="hidden" value="{{$request->student_id}}" name="student_id">
                                            <input type="hidden" value="{{$request->course_id}}" name="course_id">

                                            <button class="btn btn-danger">Decline</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
