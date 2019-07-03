<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Business\UsersBusiness;
use App\Http\Resources\UsersResource;
use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        //
    }


    /**
     * 获取用户信息
     * @param Request $request
     * @return \App\Http\Controllers\返回的数据|array
     */
    public function me(Request $request)
    {

        if (!empty($request->user())) {
            $request->user()->makeHidden(Users::SENSITIVE_FIELDS);
        }

        return $this->jsonFormat($request->user());

    }

    /**
     * 用户注册接口
     * @param Request $request
     * @param UsersBusiness $users_business
     * @return \App\Http\Controllers\返回的数据|array
     */
    public function register(Request $request, UsersBusiness $users_business)
    {

        //
        $condition = $request->only([
            'username',
            'email',
            'password',
        ]);
        $condition['password'] = Hash::make($request->get('password'));
        $user = $users_business->create($condition);
        $token = $user->createToken("Lumen Password Grant Client")->accessToken;

        return $this->jsonFormat(['token' => $token]);
    }

    public function edit($id)
    {
        //
    }

    public function update($id, Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
