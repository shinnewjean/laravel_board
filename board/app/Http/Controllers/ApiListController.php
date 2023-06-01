<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Boards;

class ApiListController extends Controller
{
    function getlist($id) {
        $Board = Boards::find($id);
        return response()->json($Board,200);
    }

    function postlist(Request $req) {
        // 유효성 체크 필요

        $boards = new Boards([
            'title' => $req->title
            ,'content' => $req->content
        ]);
        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id','title');

        // return response()->json($boards,200);
        return $arr;
    }

    function putlist(Request $request,$id) {
        $arrData = [
            'code' => '0'
            ,'msg' => ''
            // ,'errmsg' => []
            // ,'org_data' => []
            // ,'udt_data' => []
        ];

        $data = $request->only('title','content');
        $data['id'] = $id;
        // 유효성체크
        $validator = Validator::make($data,[
            'id' => 'required|integer|exists:boards'
            ,'title'    => 'required|between:3,30'
            ,'content'  => 'required|max:1000'
        ]);

        if ($validator->fails()) {
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'validat error';
            $arrData['errmsg'] = $validator->errors()->all();
        } else {
            // 업데이트 처리
            $boards = Boards::find($id); // select * from boards where id = $id

            $boards->title = $request->title;
            $boards->content = $request->content;
            $boards->save();

            $arrData['code'] = '0';
            $arrData['msg'] = 'success';
            // $arrData['errmsg'] = $boards->only('id','title');
        }
        
        return $arrData;
        
        
    }

    function deletelist(Request $request,$id) {
        $arrData = [
            'code' => '0'
            ,'msg' => ''
        ];

        $arr = ['id' => $id];
        $validator = Validator::make($arr,[
            'id' => 'required|integer|exists:boards'
        ]);

        // 유효성 체크
        if ($validator->fails()) {
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'validat error';
            $arrData['errmsg'] = $validator->errors()->all();
        } else {
            $boards = Boards::find($id);
            if ($boards) {
                $boards->delete();
                $arrData['code'] = '0';
                $arrData['msg'] = 'success';
            }
            else{
                $arrData['code'] = 'E02';
                $arrData['msg'] = 'Already Deleted';
            }
        }

        return $arrData; 
    }

}
