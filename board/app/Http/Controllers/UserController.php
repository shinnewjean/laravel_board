<?php
/***********************************************
 * 프로젝트명   :   laravel_board
 * 디렉토리     :   Controllers
 * 파일명       :   UserController.php
 * 이력         :   v001 0530 YJ.shin new
 *                  v002 0531 YJ.shin 로그아웃 기능 추가
*********************************************** */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    function login() {

        $arr['key'] = 'test';
        $arr['kim'] = 'park';

        Log::emergency('emergency',$arr);
        Log::alert('alert',$arr);
        Log::critical('critical',$arr);
        Log::error('error',$arr);
        Log::warning('warning',$arr);
        Log::notice('notice',$arr);
        Log::info('info',$arr);
        Log::debug('debug',$arr);

        return view('login');
    }

    function loginpost(Request $req) {
        // 유효성 체크
        $req->validate([
            'email'     => 'required|email|max:30'
            ,'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        // 유저 정보 습득
        $user = User::where('email',$req->email)->first();
        if (!$user || !(Hash::check($req->password, $user->password))) {
            $error = '아이디와 비밀번호를 확인해주세요.';
            // return redirect()->back()->with('errors',collect($errors));
            return redirect()->back()->with('error',$error);
        }

        // 유저 인증 작업
        Auth::login($user);
        if (Auth::check()) {
            session($user->only('id')); // 세션에 인증된 회원 pk 등록 // 0531 del 배열로감싸져있는 $user의 배열만 지움
            return redirect()->intended(route('boards.index')); // 성공시
        }
        else {
            // $errors[] = '인증작업 에러';
            $error = '인증작업 에러';
            // return redirect()->back()->with('errors',collect($errors));
            return redirect()->back()->with('error',$error);
        }

    }

    function registration() { //registration(회원가입)
        return view('registration');
    }

    function registrationpost(Request $req) {
        // 유효성 체크
        $req->validate([
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'email'    => 'required|email|max:30'
            ,'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        // password 암호화
        $data['name'] = $req->name;
        $data['email'] = $req->input('email');
        $data['password'] = Hash::make($req->password);

        // 엘로컨트를 이용해 넣어주기
        $user = User::create($data); //insert
        if(!$user) {
            // $errors[] = '시스템 에러가 발생하여, 회원가입에 실패하였습니다.';
            // $errors[] = '잠시 후에 다시 회원가입을 시도해주세요.';
            $error = '시스템 에러가 발생하여, 회원가입에 실패하였습니다.<br>잠시 후에 다시 회원가입을 시도해주세요.';
            return redirect()
                ->route('users.registration')
                // ->with('errors',collect($errors));
                ->with('error',$error);
        }

        // 회원가입 완료 로그인 페이지로 이동
        return redirect()
            ->route('users.login')
            ->with('success','회원가입을 완료 했습니다.<br>가입하신 아이디와 비밀번호로 로그인 해 주십시오.');
    }

    function logout() { // 0531 add 로그아웃기능 추가
        Session::flush(); // 세션 파기
        Auth::logout(); // 로그아웃
        return redirect()->route('users.login');
    }

    function withdraw() { // 0531 add withdraw(탈퇴)기능 추가
        $id = session('id');
        $result = User::destroy($id);
        Session::flush();
        Auth::logout();
        return redirect()->route('users.login');
    }

    function edit() {
        $user = User::find(Auth::User()->id);

        return view('useredit')->with('data', $user);
    }

    function editpost(Request $req) {
        $arrKey = []; // 수정할 항목을 배열에 담는 변수

        $baseUser = User::find(Auth::User()->id); // 기존 데이터 획득

        // 기존 패스워드 체크
        if(!Hash::check($req->bpassword, $baseUser->password)) {
            return redirect()->back()->with('error', '기존 비밀번호를 확인해 주세요.');
        }

        // 수정할 항목을 배열에 담는 처리
        if($req->name !== $baseUser->name) {
            $arrKey[] = 'name';
        }
        if($req->email !== $baseUser->email) {
            $arrKey[] = 'email';
        }
        if(isset($req->password)) {
            $arrKey[] = 'password';
        }

        // 유효성체크를 하는 모든 항목 리스트
        $chkList = [
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'email'    => 'required|email|max:100'
            ,'bpassword'=> 'regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
            ,'password' => 'same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ];

        // 유효성 체크할 항목 셋팅하는 처리
        $arrchk['bpassword'] = $chkList['bpassword'];
        foreach($arrKey as $val) {
            $arrchk[$val] = $chkList[$val];
        }

        //유효성 체크
        $req->validate($arrchk);

        // 수정할 데이터 셋팅
        foreach($arrKey as $val) {
            if($val === 'password') {
                $baseUser->$val = Hash::make($req->$val);
                continue;
            }
            $baseUser->$val = $req->$val;
        }
        $baseUser->save(); // update

        return redirect()->route('users.edit');
    }
}
