<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\TableVerify;
use App\Http\Requests\ContentVerify;

class CompanyController extends Controller
{
    //获取所有当前企业的问题
    public function getAllQuestionsInfo($id){
        $res = DB::table("chat_robot_extra_qa as t1")
            ->select("t1.id","t1.title","t1.created_at as updatetime","t1.access_at as accesstime","t1.state")
            ->leftJoin("chat_company as t2","t1.company_id","=","t2.id")
            ->leftJoin("chat_user as t3","t3.id","=","t2.chat_user_id")
            ->where("t3.id",$id)
            ->paginate(4);
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //新增问题
    public function addQuestion(TableVerify $request,$id){
        $res = DB::table("chat_robot_extra_qa")
//            ->leftJoin("chat_company as t2","t1.company_id","=","t2.id")
//            ->leftJoin("chat_user as t3","t2.chat_user_id","=","t3.id")
           ->insert([
                "title"=>$request->title,
               "synopsis"=>$request->intro,
               "step"=>$request->Method,
               "matter_need_atten"=>$request->warning,
               "created_at"=>date("Y-m-n h:i:s"),
               "access_at"=>date("Y-m-n h:i:s"),
               "state"=>1,
               "company_id"=>$id
           ]);
        if($res) {
            return response()->success(200,"成功",null);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //查看客服问答
    public function showQuestions($id){
        $res = DB::table("chat_communication")
            ->select("fromname as name","created_at as time","content")
            ->where("fromid",$id)
            ->paginate(4);
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //获取首句内容
    public function getFirstContent($id){
        $res = DB::table("chat_company as t1")
            ->select("t1.default_reply as firstContent")
            ->leftJoin("chat_user as t2","t1.chat_user_id","=","t2.id")
            ->where("t2.id","=",$id)
            ->get();
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //修改首句内容put
    public function updateFirstContent(ContentVerify $request,$id){
        $res = DB::table("chat_company as t1")
            ->leftJoin("chat_user as t2","t1.chat_user_id","=","t2.id")
            ->where("t2.id",$id)
            ->update([
                "default_reply"=>$request->content,
            ]);
        if($res) {
            return response()->success(200,"成功",null);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //显示热门问题get
    public function showHotQuestions($id){
        $res = DB::table("chat_robot_extra_qa as t1")
            ->leftJoin("chat_company as t2","t1.company_id","=","t2.id")
            ->leftJoin("chat_user as t3","t3.id","=","t2.chat_user_id")
            ->select("t1.clicks as hot","t1.title as question")
            ->where("t3.id",$id)
            ->paginate(4);
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //返回指定客服聊天记录
    public function getRecordDetail($id){
        $res = DB::table("chat_communication")
            ->select("id","fromid","fromname","toid","toname","content","created_at as updated_at")
            ->where("fromid","=",$id)
            ->orderBy("created_at","asc")
            ->paginate(4);
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //显示所有黑名单
    public function getAllBalckLists($id){//企业id
        $res = DB::table("chat_blacklist as t1")
            ->leftJoin("chat_user as t2","t1.person_id","=","t2.id")
            ->leftJoin("chat_company as t3","t3.id","=","t1.company_id")
            ->select("t2.id as userID","t2.cname as name","t2.tel as phone","t1.created_at as forbidden_time","t1.state as status")
            ->where("t3.id",$id)
            ->paginate(4);
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //显示指定黑名单详细内容
    public function showBlackList($id){//黑名单ID
        $res = DB::table("chat_blacklist as t1")
            ->leftJoin("chat_user as t2","t1.person_id","=","t2.id")
            ->select("t2.id as account","t2.cname as name","t2.tel as phone","t1.credential as evidence")
            ->where("t1.id",$id)
            ->get();
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //将指定黑名单人员移除黑名单
    public function removeBlackList($id){
        $res = DB::table("chat_blacklist")
            ->where("id",$id)
            ->delete();
        if($res) {
            return response()->success(200,"成功",$res);
        }else{
            return response()->fail(100,"失败");
        }
    }
    //将指定黑名单人员加入黑名单put
    public function addBlackList($id){
        $res = DB::table("chat_blacklist")
            ->insert([
                "company_id"=>$id,
                "person_id"=>$id,
                "credential"=>'111',
                "created_at"=>date('Y-m-n h:i:s'),
                'state'=>0,
                'service_id'=>1
            ]);
        if($res) {
            return response()->success(200,"成功",null);
        }else{
            return response()->fail(100,"失败");
        }
    }
}
