@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Appointments</div>

                <div class="card-body">
                    <table class="table">
                        @if(count($appointments))
                            <tr>
                                <th style="text-align: center">
                                    Coach
                                </th>
                                <th style="text-align: center">
                                    Course title
                                </th>
                                <th style="text-align: center">
                                    Date
                                </th>
                            </tr>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>
                                        {{$appointment->course->user->name}}
                                    </td>
                                    <td>
                                        {{$appointment->course->title}}
                                    </td>
                                    <td>
                                        {{$appointment->appointment_date}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
