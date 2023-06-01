<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit</title>
</head>
<body>
	{{-- add.230530 title,content 에러 체크 하는 구문 --}}
	@if(count($errors)>0)
		@foreach($errors->all() as $error) {{-- $errors->all() _ 에러를 배열로 가져옴 --}}
			<div>{{$error}}</div>
		@endforeach
	@endif
	{{-- add end.230530 에러 체크 하는 구문 --}}

	<form action="{{route('boards.update', ['board' => $data->id])}}" method="post">
		@csrf
		@method('put')
		{{-- <input type="text" name="id" id="id" value="@if(count($errors)>0){{old('id')}}@else{{$data->id}}@endif"> --}}

		<label for="title">제목 : </label>
		<input type="text" name="title" id="title" value="{{count($errors) > 0 ? old('title') : $data->title }}"> {{-- add.230530 value="{{old('title')}}: error발생시 old(이전 입력값 조회하기)를 유지 {{ check() ? 'yes' : 'no' }}--}}
		{{-- value="@if(count($errors)>0){{old('title')}}@else{{$data->title}}@endif" --}}
		<br>
		<label for="content">내용 : </label>
		<textarea name="content" id="content">{{count($errors) > 0 ? old('title') : $data->title }}</textarea> {{-- add.230530 {{old('content')}}: error발생시 old(이전 입력값 조회하기)를 유지 --}}
		<br>
		<button type="submit">수정</button>
		<button type="button" onclick="location.href='{{Route('boards.show', ['board' => $data->id])}}'">취소</button>
	</form>
</body>
</html>