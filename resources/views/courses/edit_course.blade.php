@extends('layouts.app')

@section('content')
	<form action="update" method="POST">
		@csrf
		<input class="form-control" type="text" name="title" placeholder="Course Title" value="{{$course->title}}">
		<input class="form-control" type="text" name="trainer" placeholder="Course Trainer" value="{{$course->trainer}}">
		<textarea class="form-control" name="about" placeholder="About Course">{{$course->about}}</textarea>
		<input type="hidden" name="id" value="{{$course->id}}">

		<button type="submit" class="btn btn-success">Submit</button>
		<button type="button" class="btn btn-secondary" onclick="location.href='/course'">Back</button>
	</form>
@endsection