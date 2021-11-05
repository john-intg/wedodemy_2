@extends('layouts.app')

@section('content')
<h1>Final Exam for {{$course->title}}</h1>
<script type="text/javascript">
	function editQuestion(question_id){
		document.getElementById('saveButtonQuestion'+question_id).style.display = 'inline-block';
		document.getElementById('editButtonQuestion'+question_id).style.display = 'none';
		document.getElementById('question_named'+question_id).readOnly = false;
		document.getElementById('question_points'+question_id).style.display = 'inline-block';
		document.getElementById('question_point_span'+question_id).style.display = 'none';

	}
	function saveQuestion(question_id){
		document.getElementById('editButtonQuestion'+question_id).style.display = 'inline-block';
		document.getElementById('saveButtonQuestion'+question_id).style.display = 'none';
		document.getElementById('question_named'+question_id).readOnly = true;

	}

	function copyQuestion(question_id){
		var sameQuestion = document.getElementById('question_named'+question_id).value;
		var samePoints = document.getElementById('question_points'+question_id).value;
		document.getElementById('question_name'+question_id).value = sameQuestion;
		document.getElementById('points'+question_id).value = samePoints;
	}

	function editChoiceFunction(choice_id){
		document.getElementById('oldCheckbox'+choice_id).removeAttribute("readonly");
		document.getElementById('saveButtonChoice'+choice_id).style.display = 'inline-block';
		document.getElementById('editButtonChoice'+choice_id).style.display = 'none';
		document.getElementById('oldChoiceName'+choice_id).readOnly = false;
	}
	function saveChoiceFunction(choice_id){
		document.getElementById('oldCheckbox'+choice_id).setAttribute("readonly","");
		document.getElementById('editButtonChoice'+choice_id).style.display = 'inline-block';
		document.getElementById('saveButtonChoice'+choice_id).style.display = 'none';
		document.getElementById('newChoiceName'+choice_id).value = document.getElementById('oldChoiceName'+choice_id).value;
		document.getElementById('oldChoiceName'+choice_id).readOnly = true;
		var oldCheckbox = document.getElementById('oldCheckbox'+choice_id);
		if (oldCheckbox.checked == true) {
			document.getElementById('newCheckbox'+choice_id).value = 1;
		}
		else{
			document.getElementById('newCheckbox'+choice_id).value = 0;
		}
		
	}
	
</script>
<?php $question_counter = 1; ?>
@if(count($questions)>0)
	@foreach($questions as $question)
		<div class="container-fluid">
				
				<table class="table">
					<tr>
						<td>
							<div class='input-group'>
								<div class='input-group-prepend'>
									<span class='input-group-text'>{{$question_counter}}</span>
								</div>
								<input type="text" class="form-control" id="question_named{{$question->id}}" onchange="copyQuestion('{{$question->id}}')" name="question_name" value="{{$question->question_name}}" readonly="">
								<div class='input-group-prepend'>
									<input type="number" class="form-control" id="question_points{{$question->id}}" onchange="copyQuestion('{{$question->id}}')" name="question_points" value="{{$question->points}}" style="display: none;">
									<span class="input-group-text" id="question_point_span{{$question->id}}" style="display: inline-block;">{{$question->points}} points</span>
								</div>
							</div>
						</td>
						<td>
							<form action="updateQuestion" method="post" enctype="multipart/form-data"  style="display: inline-block;">
								@csrf
								<input type="hidden" name="id" value="{{$question->id}}">
								<input type="hidden" id="question_name{{$question->id}}" name="question_name" value="{{$question->question_name}}">
								<input type="hidden" id="points{{$question->id}}" value="{{$question->points}}" name="points">

								<button type="submit" class="btn btn-info" id="saveButtonQuestion{{$question->id}}" style="display: none;" onclick="saveQuestion('{{$question->id}}')">Save</button>
								<button type="button" class="btn btn-primary" id="editButtonQuestion{{$question->id}}" onclick="editQuestion('{{$question->id}}')">Edit</button>
							</form>
							<form action="destroyQuestion/{{$question->id}}" method="post" style="display: inline-block;">		
								@csrf
								<input type="hidden" name="id" value="{{$question->id}}">
								<button type="submit" class="btn btn-danger" >Delete</button>
							</form>
						</td>
					</tr>
				</table>
			<div class="container-fluid mb-3">
				<?php $choicesInQuestion =  $choices->where('question_id', $question->id); ?>
				@if(count($choicesInQuestion)>0)
					<table class="table">
						<tr>
							<th>Choices</th>	
							<th class="text-center">Correct choice/s</th>	
							<th>Action for choices</th>	
						</tr>
						@foreach($choicesInQuestion as $choice)
							<tr>
								<td>
									<input class="form-control" type="text" id="oldChoiceName{{$choice->id}}" value="{{$choice->choice_name}}" readonly>
								</td> 
								<td>
									<input class="form-control" type="checkbox" readonly="" id="oldCheckbox{{$choice->id}}" <?php if ($choice->correct_choice) echo 'checked'; ?> onclick="checkboxFunction({{$choice->id}})">

								</td>
								<td>
									<form method="post" action="updateChoice/{{$choice->id}}" class="inline-block" style="display: inline-block;">
										@csrf
										<input type="hidden" name="choice_name" id="newChoiceName{{$choice->id}}" value="">
										<input type="hidden" name="correct_choice" id="newCheckbox{{$choice->id}}" value="">
										<button class="btn btn-info" id="saveButtonChoice{{$choice->id}}" onclick="saveChoiceFunction('{{$choice->id}}')" style="display: none;">Save</button>
									</form>
										<button class="btn btn-primary" id="editButtonChoice{{$choice->id}}" onclick="editChoiceFunction('{{$choice->id}}')">Edit</button>
									<form method="post" action="destroyChoice/{{$choice->id}}" style="display: inline-block;">
										@csrf
										<button class="btn btn-danger">Delete</button>
									</form>
								</td>
							</tr>
						@endforeach
					</table>
				@endif
					<button class="btn btn-success" data-toggle="modal" data-target="#AddChoiceModal{{$question->id}}">Add Choices</button>
			</div>
		</div>
		<?php $question_counter++; ?>
{{-- add Choice --}}
		@if(count($questions) > 0)
			<form action="addChoice" method="post">
				@csrf
				<div class="modal fade" id="AddChoiceModal{{$question->id}}" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add Choice</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<input type="text" class="form-control" name="choice_name" placeholder="Add choice">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="customSwitch{{$question->id}}" value="1" name="correct_choice">
									<label class="custom-control-label" for="customSwitch{{$question->id}}">On this for correct choice</label>
								</div>
								<input type="hidden" name="question_id" value="{{$question->id}}">
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success">Add Choice</button>
							</div>
						</div>
					</div>
				</div>
			</form>	
		@endif
{{-- End of add choice --}}
	@endforeach
@endif
	<button class="btn btn-primary" data-toggle = "modal" data-target= "#AddQuestionModal">Add Question</button>

{{-- add Quesion --}}
<form action="addQuestion" method="post" enctype="multipart/form-data">
    @csrf
	<div class="modal fade" id="AddQuestionModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <textarea class="form-control" name="question_name" placeholder="add Question or instruction">
	        </textarea>
	        <input type="number" placeholder="how many points?" class="form-control" name="points">
	        <input type="hidden" name="course_id" value="{{$course->id}}">

	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Add Question</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>






@endsection


