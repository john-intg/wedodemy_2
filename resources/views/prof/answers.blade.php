@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Student Answers</div>
                <div class="card-body">
                    @if(count($exams)>0)
                        <table class="table">
                            <tr>
                                <th>Course</th>
                                <th>Student</th>
                                <th>Action</th>
                            </tr>
                            @foreach($courses as $course)
                                {{-- <?php $examinees = $course->exams; ?> --}}
                                @foreach($course->exams as $examinee)
                                    <tr>
                                        <td>
                                            {{$course->title}}
                                        </td>
                                        <td>
                                            {{$examinee->name}}
                                        </td>
                                        <td>
                                            {{$examinee->pivot->created_at}}
                                        </td>
                                        <td>
                                            <form method="post" action="answer">
                                                @csrf
                                                <input type="hidden" value="{{$examinee->pivot->created_at}}" name="time">
                                                <input type="hidden" value="{{$examinee->id}}" name="student">
                                                <input type="hidden" name="course" value="{{$course->id}}">
                                                @if($examinee->pivot->isPassed === null)
                                                    <button class="btn btn-warning">View</button>
                                                @elseif($examinee->pivot->isPassed === 0)
                                                    <button class="btn btn-danger">Bagsak</button>
                                                @elseif($examinee->pivot->isPassed === 1)
                                                    <button class="btn btn-success">Passed</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
