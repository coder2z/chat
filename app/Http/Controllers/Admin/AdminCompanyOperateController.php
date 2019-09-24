<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCompanyOperateRequest;
use App\Http\Requests\Admin\CompanyIdRequest;
use App\Http\Requests\Admin\CustomerIdRequest;
use App\Models\Company;
use App\Models\User;

class AdminCompanyOperateController extends Controller
{
    public function getAllCompany()
    {
        $data = User::where('type', 'company')->paginate(8);
        $result = ['code' => '200', 'msg' => '成功', 'data' => $data];
        return response()->json($result);
    }
    public function addCompany(AdminCompanyOperateRequest $request)
    {
        $userCompany = new User();
        $userCompany->cname = $request->get('company_name');
        $userCompany->password = bcrypt($request->get('password'));
        $userCompany->type = 'company';
        $userCompany->tel = $request->get('company_phone');
        $userCompany->created_at = date('Y-m-d h:i:s', time());
        $resultUserCompany = $userCompany->save();


        $companyId = User::where('cname', $request->get('company_name'))->value('id');
        // dd($companyId);

        $company = new Company();
        $company->company_name = $request->get('company_name');
        $company->url = $companyId;
        $company->created_at = date('Y-m-d h:i:s', time());
        $company->chat_user_id = $companyId;
        $resultCompany = $company->save();

        if ($resultUserCompany && $resultCompany) {
            $result = ['code' => '200', 'msg' => '成功', 'data' => null];
        } else {
            $result = ['code' => '100', 'msg' => '失败', 'data' => null];
        }

        return response()->json($result);
    }
    public function deleteCompanyByCompanyId(CompanyIdRequest $request)
    {
        $id = $request->get('company_id');

        $userCompany = User::where('id', $id)->first();
        $resultUserCompany = $userCompany->delete();


        $company = Company::where('chat_user_id', $id);
        $resultCompany = $company->delete();

        if ($resultUserCompany && $resultCompany) {
            $result = ['code' => '200', 'msg' => '成功', 'data' => null];
        } else {
            $result = ['code' => '100', 'msg' => '失败', 'data' => null];
        }

        return response()->json($result);
    }
}
