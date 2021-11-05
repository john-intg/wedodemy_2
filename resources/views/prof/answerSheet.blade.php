@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$answers->first()->user->name}}'s answers on {{$answers->first()->course->title}}</div>  
                <div class="card-body" pointer-events="none">
                	<input type="text" value="{{$questions->sum('points')}}" name="">
                    @foreach($questions as $question)
                    	<div class='input-group' style="padding-top: 15px">
							<div class='input-group-prepend'>
								<span class='input-group-text'>{{$counter++}}</span>
							</div>
							<input type="text" class="form-control" value="{{$question->question_name}}" disabled>
							<div class='input-group-prepend'>
								<input class="form-control" type="number" class="score" title="Max points {{$question->points}}" max="{{$question->points}}" value="{{$question->points}}">
							</div>
						</div>
						<?php $correctChoice = $question->choices->where('correct_choice', 1); ?>
						<div class="answer">
							@if(count($correctChoice)>1){{-- if checkbox --}}
								@foreach($question->choices as $choice)
									@if(count($choice->answers->where('created_at', $time))){{-- if student answer --}}
										@if($choice->correct_choice){{-- if student is correct --}}
											<div class="form-check">
							  					<input class="form-check-input" readonly="" type="checkbox" id="{{$choice->id}}" value="{{$choice->id}}" checked>
							  					<label class="form-check-label text-success" for="{{$choice->id}}">
							    					{{$choice->choice_name}}
											  	</label>
											</div>
										@else{{-- if student is wrong --}}
											<div class="form-check">
							  					<input class="form-check-input" readonly="" type="checkbox" id="{{$choice->id}}" value="{{$choice->id}}" checked>
							  					<label class="form-check-label text-danger" for="{{$choice->id}}">
							    					{{$choice->choice_name}}
											  	</label>
											</div>
										@endif{{--end if student is wrong --}}
									@else {{-- not student choice--}}
										@if($choice->correct_choice)
											<div class="form-check">
							  					<input class="form-check-input" readonly="" type="checkbox" id="{{$choice->id}}" value="{{$choice->id}}" >
							  					<label class="form-check-label text-primary" for="{{$choice->id}}">
							    					{{$choice->choice_name}}
											  	</label>
											</div>
										@else
											<div class="form-check">
							  					<input class="form-check-input" readonly="" type="checkbox" id="{{$choice->id}}" value="{{$choice->id}}" >
							  					<label class="form-check-label" for="{{$choice->id}}">
							    					{{$choice->choice_name}}
											  	</label>
											</div>
										@endif
									@endif
								@endforeach
							@elseif(count($correctChoice) ==1){{--if radio button--}}
								@foreach($question->choices as $choice)
									@if(count($choice->answers->where('created_at', $time)))
										@if($choice->correct_choice)
											<div class="form-check">
							  					<input class="form-check-input" id="{{$choice->id}}" readonly="" type="radio" name="choice_id[{{$question->id}}]" value="{{$choice->id}}" checked>
							  					<label class="form-check-label text-success" for="{{$choice->id}}">
							   						{{$choice->choice_name}}
							  					</label>
											</div>
										@else
											<div class="form-check">
							  					<input class="form-check-input" id="{{$choice->id}}" readonly="" type="radio" name="choice_id[{{$question->id}}]" value="{{$choice->id}}" checked>
							  					<label class="form-check-label text-danger" for="{{$choice->id}}">
							   						{{$choice->choice_name}}
							  					</label>
											</div>
										@endif
									@else
										@if($choice->correct_choice)
											<div class="form-check">
							  					<input class="form-check-input" id="{{$choice->id}}" readonly="" type="radio" name="choice_id[{{$question->id}}]" value="{{$choice->id}}">
							  					<label class="form-check-label text-primary" for="{{$choice->id}}">
							   						{{$choice->choice_name}}
							  					</label>
											</div>
										@else
											<div class="form-check">
							  					<input class="form-check-input" id="{{$choice->id}}" readonly="" type="radio" name="choice_id[{{$question->id}}]" value="{{$choice->id}}">
							  					<label class="form-check-label" for="{{$choice->id}}">
							   						{{$choice->choice_name}}
							  					</label>
											</div>
										@endif
									@endif
								@endforeach
							@else
							<?php $answer = $question->answers->where('created_at', $time)->first(); ?>
								<textarea class="form-control" disabled>{{$answer->answer}}</textarea>
							@endif
						</div>
                    @endforeach
                    <button class="btn btn-success" style="float: right">Total Score</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

                    {{-- @foreach($answers as $answer)
                    	<br>
                    	<?php 
                    		$prevAnswer = $answer->where('id', '<', $answer->id)->orderBy('id', 'desc')->first(); 
                    		$nextAnswer = $answer->where('id', '>',$answer->id)->orderBy('id')->first();
                    	?>
                    	
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>{{$counter}}</span>
							</div>
							<input type="text" class="form-control" value="{{$answer->question->question_name}}" disabled>
						</div>
						@if(count($answer->question->choices) > 0)
							<?php $correctChoice = $answer->question->choices->where('correct_choice', 1); ?>
							<?php $correctChoice = $question->choices->where('correct_choice', 1); ?>
							@ifunt($correctChoice)>1)
								<?php $counter = 0 ?>
								@foreach($answer->question->choices as $choice)
									<div class="form-check">
					  					<input class="form-check-input" type="checkbox" name="choice_id[{{$answer->question->id}}][{{$counter}}]" id="{{$choice->id}}" value="{{$choice->id}}">
					  					<label class="form-check-label" for="{{$choice->id}}">
					    					{{$choice->choice_name}}
									  	</label>
									</div>
							<?php $counter++ ?>
								@endforeach
							@elseif(count($correctChoice)==1)
								@foreach($answer->question->choices as $choice)
									<div class="form-check">
					  					<input class="form-check-input" id="{{$choice->id}}" type="radio" name="choice_id[{{$answer->question->id}}]" value="{{$choice->id}}">
					  					<label class="form-check-label" for="{{$choice->id}}">
					   						{{$choice->choice_name}}
					  					</label>
									</div>
								@endforeach
							@else
								<input type="text" class="form-control" placeholder="Answer" name="answer[{{$answer->question->id}}]">
								<input type="hidden" placeholder="CourseID" name="course_id" value="{{$course->id}}">

							@endif
						@endif
						<div>
						@if($answer->is_correct)
							<input type="text" class="form-control text-success" value="{{$answer->choice->choice_name}}">
						@elseif(is_null($answer->is_correct))
							<input type="text" class="form-control" value="{{$answer->answer}}">
						@endif
						</div>
						@isset($nextAnswer->question_id)
							<?php
								if ($nextAnswer->question_id == $answer->question_id) {
									$counter;
								}
								else{
									$counter++;
								}
							?>
						@endisset
                    @endforeach --}}