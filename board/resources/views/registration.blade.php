@extends('layout.layout') {{-- 부모의 요소 가져오기 --}}

@section('title','registration')

@section('contents')
<h1>Registration</h1>
	@include('layout.errorsvalidate')

    <form action="{{route('users.registration.post')}}" method="post">
        @csrf {{-- 서큐리티 --}}
        <label for="name">Name : </label>
        <input type="text" name="name" id="name">
        <br>

        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>

        <label for="passwordchk">Password check : </label>
        <input type="password" name="passwordchk" id="passwordchk">
        <br>

        <button type="submit">registration</button>
        <button type="button" onclick="location.href = '{{route('users.login')}}'">Cancel</button>
    </form>
@endsection