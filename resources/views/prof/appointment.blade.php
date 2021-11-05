@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Appointments</div>

                <div class="card-body">
                    <table class="table">
                        @if(count($courses)> 0)
                            <tr>
                                <th>
                                    Requester
                                </th>
                                <th>
                                    Course title
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            @foreach($courses as $course)
                                <?php $appointments = $course->appointments->where('appointment_done', 0); ?>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>
                                            {{$appointment->user->name}}
                                        </td>
                                        <td>
                                            {{$course->title}}
                                        </td>
                                        <td>
                                            {{$appointment->appointment_date}}
                                        </td>
                                        <td>
                                            @if($appointment->appointment_confirm)
                                                <form action="doneAppointment" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$appointment->id}}" name="id">
                                                    <button class="btn btn-primary">Done</button>
                                                    
                                                </form>
                                            @else
                                                <form style="display: inline-block;" action="confirmAppointment" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$appointment->id}}" name="id">
                                                    <button class="btn btn-success">Confirm</button>
                                                </form>
                                                <form style="display: inline-block;" action="declineAppointment" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$appointment->id}}" name="id">
                                                    <button class="btn btn-danger">Decline</button>
                                                </form>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection