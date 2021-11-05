@extends('layouts.app')

@section('content')
	<form action="store" method="post">
		@csrf
		<input class="form-control" type="text" name="title" placeholder="Course Title">
		<input class="form-control" type="hidden" value="{{Auth::user()->name}}" name="trainer" placeholder="Course Trainer">
		<textarea class="form-control" name="about" placeholder="About Course">
		</textarea>

		<button type="submit" class="btn btn-success">Submit</button>
	</form>
@endsection