	{{-- add.230530 발리데이트 에러 체크 하는 구문 --}}
	@if(count($errors)>0)
		@foreach($errors->all() as $error) {{-- $errors->all() _ 에러를 배열로 가져옴 --}}
			<div>{{$error}}</div>
		@endforeach
	@endif
	{{-- add end.230530 에러 체크 하는 구문 --}}
	
	{{-- add.230531 따로 설정한 에러 체크 하는 구문 --}}
	@if(session()->has('error'))
		<div>{!! session('error') !!}</div>
	@endif
	{{-- add end.230531 따로 설정한 에러 체크 하는 구문 --}}