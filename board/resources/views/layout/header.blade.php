<h2>Header</h2>

{{-- 0531 add 로그인,로그아웃,회원정보수정 버튼 --}}
{{-- 로그인 상태(인증이 된 상태) --}}
@auth
    {{-- <div>$user['name']</div> --}}
    <div><a href="{{route('users.edit')}}">회원정보 수정</a></div>
    <div><a href="{{route('users.logout')}}">로그아웃</a></div>
@endauth

{{-- 비로그인상태(인증이 안된 상태) --}}
@guest
    <div><a href="{{route('users.login')}}">로그인</a></div>
@endguest   
{{-- 0531 add.end 로그아웃 버튼 --}}

<hr>