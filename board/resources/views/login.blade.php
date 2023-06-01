@extends('layout.layout') {{-- 부모의 요소 가져오기 --}}

@section('title','Login')

@section('contents')
    <h1>Login</h1>
    @include('layout.errorsvalidate')
    {{-- <div>{{isset($success) ? $success : "" }}</div> 0531 change --}}
    <div>{!!session()->has('success') ? session('success') : ""!!}</div>
    <form action="{{route('users.login.post')}}" method="post">
        @csrf {{-- 서큐리티 --}}
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>

        <button type="submit">Login</button>
        <button type="button" onclick="location.href = '{{route('users.registration')}}'">Registration</button>
    </form>
@endsection