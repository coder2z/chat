<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddPersonalUserRequest;
use App\Http\Requests\SearchPersonalUserRequest;
use App\Http\Requests\UpdatePersonalUserByUserIdRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AdminPersonOperateController extends Controller
{
    public function searchPersonalUser(SearchPersonalUserRequest $request){

           $result =(new User())->where('type','person')
               ->where('cname','=',$request->input('search_content'))
               ->orwhere('tel','=',$request->input('search_content'))
               ->first();

           if($result){
               return response()->success(200,'成功',$result);
           }
           else{
               return response()->fail(100,'查无此人',null);
           }



    }

    public function getAllPersonalUser(){
        $result=(new User())->where('type','person')->paginate(8);

        if($result){

            return response()->success(200,'成功',$result);
        }else{
            return response()->fail(100,'失败',null);
        }



    }

    public function addPersonalUser(AddPersonalUserRequest $request){

            $user = new User;
            $user->cname = $request->input('person_name');
            $user->status = $request->input('person_state');
            $user->tel = $request->input('person_phone');
            $user->password = $request->input('person_password');
            $user->type = 'person';

            $localTime = $this->getLocalTime();

            $user->created_at = $localTime;


            $result = $user->save();

            if($result){
                return response()->success(200,'成功',null);
            }else{
                return response()->fail(100,'新增用户失败',null);
            }

    }

    public function updatePersonalUserByUserId(UpdatePersonalUserByUserIdRequest $request){

            $result = (new User())->where('id','=',$request->input('person_id'))
                ->update(['status'=>$request->input('person_state')]);
            if($result){
                return response()->success(200,'成功',null);
            }else{
                return response()->fail(100,'更新失败,请检查用户id是否正确',null);
            }

    }


    /**
     * @return false|string 返回当前时间戳
     */
    public function getLocalTime(){
        $localTime = date('Y-m-d H:i:s', strtotime('+8 hour'));
        return $localTime;
    }

}
