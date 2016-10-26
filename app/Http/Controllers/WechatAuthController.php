<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\Api;

use Illuminate\Support\Facades\Redis;

use Log;

class WechatAuthController extends Controller
{
    // 绑定手机页面
    public function bindCellPhone()
    {
        return view('wechatauth/bindcellphone');
    }

    /**
     * 添加小孩页面
     *
     * @return \Illuminate\Http\Response
     */
    public function addChild()
    {
        $children = $this->request->session()->get('children');
        return view('wechatauth/addchild', ['children' => $children]);
    }

    /**
     * 添加小孩接口
     *
     * @return JSON $response 执行结果反馈
     */
    public function saveChild()
    {
        if (!$this->request->has('gender') && !$this->request->has('birthday') && !$this->request->has('nickname')) {
            $error_response = [
                'status' => 10001,
                'message' => '缺少参数'
            ];
            return response()->json($error_response);
        }

        $api_data = [
            'gender' => $this->request->input('gender'),
            'birthday' => date('Y-m-d', strtotime($this->request->input('birthday'))),
            'nickname' => $this->request->input('nickname'),
        ];

        // 随机头像
        $default_avatar_index = mt_rand(1, 16);
        $default_avatar_url = 'http://img.vitabee.cn/web/open/assets/images/default_avatar/default_avatar_' . $default_avatar_index . '.jpg';
        $api_data['avatar_url'] = $default_avatar_url;

        // 添加小孩
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/add_child',
            $api_data
        );
        $member_info = $api_res['return_value'];
        unset($api_res);

        if (!$member_info) {
            $error_response = [
                'status' => 20000,
                'message' => '获取数据失败',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($error_response);
        }else {
            // 绑定成功后添加session
            $this->request->session()->set('cellphone', $member_info['cellphone']);
            $this->request->session()->set('children', empty($member_info['children'][0])?[]:$member_info['children'][0]);

            $response = [
                'status' => 10000,
                'message' => '发送成功',
                'data' => [
                    'member_info' => $member_info
                ],
                'timestamp' => time()
            ];
            return response()->json($response);
        }
    }

    /**
     * 检查验证码正确性，正确则绑定手机
     *
     * @return JSON $response 执行结果反馈
     */
    public function checkcode()
    {
        if (!$this->request->has('cellphone') && !$this->request->has('code')) {
            $error_response = [
                'status' => 10001,
                'message' => '缺少参数'
            ];
            return response()->json($error_response);
        }

        $api_data = [
            'cellphone' => $this->request->input('cellphone'),
            'password' => $this->request->input('code'),
        ];

        // 绑定手机号
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/bind_cellphone',
            $api_data
        );
        $member_info = $api_res['return_value'];
        // unset($api_res);

        if ($api_res['result_code'] == 100000 && !empty($member_info)) {
            // 绑定成功后添加session
            $this->request->session()->set('cellphone', $member_info['cellphone']);
            $this->request->session()->set('children', empty($member_info['children'][0])?[]:$member_info['children'][0]);

            $response = [
                'status' => 10000,
                'message' => '绑定成功',
                'data' => [
                    'member_info' => $member_info
                ],
                'timestamp' => time()
            ];
            return response()->json($response);
        }elseif ($api_res['result_code'] == 130011) {
            $response = [
                'status' => 20002,
                'message' => '号码已被绑定，请更换手机号',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($response);
        }else {
            $error_response = [
                'status' => 20003,
                'message' => '验证失败',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($error_response);
        }
    }

    /**
     * 发送短信验证码。
     *
     * @return JSON $response 执行结果反馈
     */
    public function sendCode()
    {
        // 验证入参
        if (!$this->request->has('cellphone')) {
            $error_response = [
                'status' => 10001,
                'message' => '缺少参数'
            ];
            return response()->json($error_response);
        }
        $cellphone = $this->request->input('cellphone');
        // 请求接口
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/login_code',
            [
                'cellphone' => $cellphone,
            ]
        );
        $login_code_res = $api_res['return_value'];
        // unset($api_res);

        // 拼装返回结果
        if($api_res['result_code'] == 100000){
            $response = [
                'status' => 10000,
                'message' => '发送成功',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($response);
        }else{
            $error_response = [
                'status' => 20000,
                'message' => '获取数据失败',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($error_response);
        }
    }

    /**
     * Vitabee AUth Server 的回调地址。
     * 接收微信认证后的回调参数，进行后端接口认证，
     * 通过认证则将基本信息存入session，
     * 认证成功后，重定向回到最初用户访问的链接。
     *
     * @return null
     */
    public function getToken()
    {
        $openid = $this->request->input('openid');
        $access_token = $this->request->input('access_token');
        $expires_in = $this->request->input('expires_in');
        $refresh_token = $this->request->input('refresh_token');
        $unionid = $this->request->input('unionid');
        $redirect_back_uri = $this->request->input('lu');

        // 后端API三方授权登录认证。
        $api_data = [
            'open_platform' => 1,
            'uid' => $openid,
            'access_token' => $access_token,
            'expires_in' => $expires_in,
            'refresh_token' => $refresh_token,
            'unionid' => $unionid,
        ];

        // wechatLogin
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/login_with_3rd_platform',
            $api_data
        );
        $member_info = $api_res['return_value'];
        unset($api_res);

        // 认证会员信息存入session
        if (!empty($member_info['token_key']) && !empty($member_info['token_secret'])) {
            // 微信授权信息存入session
            $this->request->session()->set('openid', $openid);
            $this->request->session()->set('access_token', $access_token);
            $this->request->session()->set('refresh_token', $refresh_token);
            $this->request->session()->set('unionid', $unionid);
            // API三方登录信息存入session
            $this->request->session()->set('token_key', $member_info['token_key']);
            $this->request->session()->set('token_secret', $member_info['token_secret']);
            $this->request->session()->set('member_id', $member_info['member_id']);
            $this->request->session()->set('cellphone', $member_info['cellphone']);
            $this->request->session()->set('avatar_url', $member_info['avatar_url']);
            $this->request->session()->set('children', empty($member_info['children'][0])?[]:$member_info['children'][0]);
            $this->request->session()->set('member_info', $member_info);
        }

        return redirect($redirect_back_uri);
    }

    /**
     * 青春浙江登录认证的回调地址。
     * 接收青春浙江登录认证后的回调参数，进行后端接口认证，
     * 通过认证则将基本信息存入session，
     * 认证成功后，重定向回到最初用户访问的链接。
     *
     * @return null
     */
    public function getZjtsw()
    {
        $memberid = $this->request->input('memberid');
        $membername = $this->request->input('membername');

        // 暂定不接收用户访问地址，直接跳转首页
        // $redirect_back_uri = $this->request->input('lu');
        $redirect_back_uri = $this->request->expert_code . '/familyread';

        // 后端API三方授权登录认证。
        $api_data = [
            'open_platform' => 3,
            'uid' => $memberid,
            'membername' => $membername,
        ];

        // wechatLogin
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/login_with_3rd_platform',
            $api_data
        );
        $member_info = $api_res['return_value'];
        unset($api_res);

        // 认证会员信息存入session
        if (!empty($member_info['token_key']) && !empty($member_info['token_secret'])) {
            // 微信授权信息存入session
            $this->request->session()->set('openid', $memberid);
            $this->request->session()->set('membername', $membername);
            // API三方登录信息存入session
            $this->request->session()->set('token_key', $member_info['token_key']);
            $this->request->session()->set('token_secret', $member_info['token_secret']);
            $this->request->session()->set('member_id', $member_info['member_id']);
            $this->request->session()->set('cellphone', $member_info['cellphone']);
            $this->request->session()->set('avatar_url', $member_info['avatar_url']);
            $this->request->session()->set('children', empty($member_info['children'][0])?[]:$member_info['children'][0]);
            $this->request->session()->set('member_info', $member_info);
        }

        return redirect($redirect_back_uri);
    }
}
