@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h1>Final Exam for {{$course->title}}</h1></div>

                <div class="card-body">
					<form method="post" action="answer">
						@csrf
						<?php $questionCounter =1; ?>
						@foreach($course->questions as $question)
							<br>
							<div class='input-group'>
								<div class='input-group-prepend'>
									<span class='input-group-text'>{{$questionCounter}}</span>
								</div>
								<input type="text" class="form-control" value="{{$question->question_name}}" readonly="">
								<div class='input-group-prepend'>
									<span class='input-group-text'>{{$question->points}} points</span>
								</div>
							</div>
							<?php $correctChoice = $question->choices->where('correct_choice', 1); ?>
							@if(count($correctChoice)>1)
						<?php $counter = 0 ?>
								@foreach($question->choices as $choice)
									<div class="form-check">
					  					<input class="form-check-input" type="checkbox" name="choice_id[{{$question->id}}][{{$counter}}]" id="{{$choice->id}}" value="{{$choice->id}}">
					  					<label class="form-check-label" for="{{$choice->id}}">
					    					{{$choice->choice_name}}
									  	</label>
										<input type="hidden" placeholder="CourseID" name="course_id" value="{{$course->id}}">
									</div>
							<?php $counter++ ?>
								@endforeach
							@elseif(count($correctChoice)==1)
								@foreach($question->choices as $choice)
									<div class="form-check">
					  					<input class="form-check-input" id="{{$choice->id}}" type="radio" name="choice_id[{{$question->id}}]" value="{{$choice->id}}">
					  					<label class="form-check-label" for="{{$choice->id}}">
					   						{{$choice->choice_name}}
					  					</label>
					  					{{-- <input type="text" placeholder="QuestionID" name="question_id[{{$question->id}}]" value="{{$question->id}}"> --}}
										<input type="hidden" placeholder="CourseID" name="course_id" value="{{$course->id}}">
									</div>
								@endforeach
							@else
								<textarea class="form-control" placeholder="Answer" name="answer[{{$question->id}}]"></textarea>
								{{-- <input type="text" placeholder="QuestionID" name="question_id[{{$question->id}}]" value="{{$question->id}}"> --}}
								<input type="hidden" placeholder="CourseID" name="course_id" value="{{$course->id}}">

							@endif
							<?php $questionCounter++; ?>
						@endforeach
						<br>
						<button class="btn btn-success">Submit</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection