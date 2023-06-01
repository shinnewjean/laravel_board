@extends('layout.layout')

@section('title', 'UserEdit')

@section('contents')
	<H1>UserEdit</H1>
	@include('layout.errorsvalidate')
	<form action="{{route('users.edit.post')}}" method="post">
		@csrf
		<label for="name">name : </label>
		<input type="text" name="name" id="name" value="{{$data->name}}">
		<br>
		<label for="email">Email : </label>
		<input type="text" name="email" id="email" value="{{$data->email}}">
		<br>
		<label for="bpassword">Before password : </label>
		<input type="password" name="bpassword" id="bpassword">
		<br>
		<label for="password">After password : </label>
		<input type="password" name="password" id="password">
		<br>
		<label for="passwordchk">After passwordchk : </label>
		<input type="password" name="passwordchk" id="passwordchk">
		<br><br>
		<button type="submit">Edit</button>
		<button type="button" onclick="location.href = '{{route('boards.index')}}'">Cancel</button>
	</form>
@endsection