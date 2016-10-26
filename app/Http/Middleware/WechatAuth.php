<?php

namespace App\Http\Middleware;

use Closure;
use Log;

use Illuminate\Support\Facades\App;
use App\Services\Api;

class WechatAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->_isLogin($request)){
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                // Header有token-key&token-secret，直接认证登录，获取用户信息并设置session。
                if ($this->_isTokenInHeader($request)) {
                    $is_login = $this->_loginWithHeaderToken($request);

                    if (!$is_login) {
                        // 登录失败
                        return ;
                    }
                }

                // 检查session判断是否登录
                if (!$this->_isLogin($request)) {
                    // 只有当expert_code为青春浙江时，跳转对方认证登录流程
                    if ($request->expert_code == 'zhejiangtsw') {
                        // 获取青春浙江认证重定向地址并重定向至青春浙江认证
                        $go_to_auth = $this->_getZhejiangtswAuthUrl($request);

                        return redirect($go_to_auth);
                    }

                    // 获取微信认证重定向地址并重定向至微信认证
                    $go_to_auth = $this->_getWechatAuthUrl($request);

                    return redirect($go_to_auth);
                }
            }
        }

        return $next($request);
    }

    /**
     * 检测是否有用户登录状态。
     * 登录状态以session中是否有用户的token_key,token_secret为依据。
     *
     * @param \Illuminate\Http\Request $request Request实例
     * @return boolean $is_login 已登录(true)/未登录(false)
     */
    private function _isLogin($request)
    {
        // 读取session，检测token-key&token-secret
        $token_key = $request->session()->get('token_key');
        $token_secret = $request->session()->get('token_secret');
        $is_login = false;
        if(!empty($token_key) && !empty($token_secret))
        {
            $is_login = true;
        }

        return $is_login;
    }

    /**
     * 检测用户请求头信息中是否包含token-key&token-secret。
     *
     * @param \Illuminate\Http\Request $request Request实例
     * @return boolean $is_login 存在token*(true)/不存在token*(false)
     */
    private function _isTokenInHeader($request)
    {
        // 读取session，检测token-key&token-secret
        $token_key = $request->header('token_key');
        $token_secret = $request->header('token_secret');
        $has_token_in_header = false;
        if(!empty($token_key) && !empty($token_secret))
        {
            $has_token_in_header = true;
        }

        return $has_token_in_header;
    }

    /**
     * 从Header信息里取出token，进行登录并获取用户信息存入session
     *
     * @param \Illuminate\Http\Request $request Request实例
     * @return boolean $is_login 是否静默登录成功
     */
    private function _loginWithHeaderToken($request)
    {
        // 初始化$is_login为false
        $is_login = false;

        // 取header中的token*存入session
        $request->session()->set('token_key', $request->header('token_key'));
        $request->session()->set('token_secret', $request->header('token_secret'));

        // 获取用户信息
        $api = new Api($request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_member_with_children',
            []
        );
        if ($api_res['result_code'] == 100000) {
            $member_info = $api_res['return_value'];
        }else {
            // 抛出异常
        }
        unset($api_res);

        // 认证会员信息存入session
        if (!empty($member_info['token_key']) && !empty($member_info['token_secret'])) {
            // API三方登录信息存入session
            $request->session()->set('token_key', $member_info['token_key']);
            $request->session()->set('token_secret', $member_info['token_secret']);
            $request->session()->set('member_id', $member_info['member_id']);
            $request->session()->set('cellphone', $member_info['cellphone']);
            $request->session()->set('avatar_url', $member_info['avatar_url']);
            $request->session()->set('children', empty($member_info['children'][0])?[]:$member_info['children'][0]);
            $request->session()->set('member_info', $member_info);

            $is_login = true;
        }

        return $is_login;
    }

    /**
     * 获取微信认证重定向地址
     *
     * @param \Illuminate\Http\Request $request Request实例
     * @return string $go_to_auth 微信授权认证服务地址
     */
    private function _getWechatAuthUrl($request)
    {
        // 获取完整的请求地址，例：http://open.vitabee.cn/vitabee/familyread?oo=xx
        $redirect_back_url = $request->fullUrl();
        // 过滤问号后面的query值，微信可能会自动加入一些值，导致授权认证跳转时出现传递state内回调地址过长的问题
        $url_arr = parse_url($redirect_back_url);
        $url_query = [];
        if (!empty($url_arr['query'])) {
            $url_query = explode('&', $url_arr['query']);
            // 微信自动加入参数过滤列表
            $wechat_query_except = [
                'from',
                'isappinstalled',
            ];
            // 开始过滤
            foreach ($url_query as $key=>$value) {
                $query_meta = explode('=', $value);
                if (in_array($query_meta[0], $wechat_query_except)) {
                    unset($url_query[$key]);
                }
                unset($query_meta);
            }
        }
        $redirect_back_uri = $url_arr['path'];
        if (!empty($url_query)) {
            $redirect_back_uri .= '?' . implode('&', $url_query);
        }
        // Log::debug(strlen($redirect_back_uri));
        unset($redirect_back_url,$url_arr);

        // 拼接授权重定向地址
        $auth_server_url = config('app.auth_server.base_url');
        $auth_callback_url = config('app.url') . '/' . $request->expert_code . '/w/g?lu=' . $redirect_back_uri;
        $go_to_auth = $auth_server_url . '/authwechat/user_auth?callback_url=' . urlencode($auth_callback_url);

        return $go_to_auth;
    }

    /**
     * 获取青春浙江认证重定向地址
     *
     * @param \Illuminate\Http\Request $request Request实例
     * @return string $go_to_auth 青春浙江登录认证服务地址
     */
    private function _getZhejiangtswAuthUrl($request)
    {
        // 获取完整的请求地址，例：http://open.vitabee.cn/vitabee/familyread?oo=xx
        $redirect_back_url = $request->fullUrl();
        // 过滤问号后面的query值，微信可能会自动加入一些值，导致授权认证跳转时出现传递state内回调地址过长的问题
        $url_arr = parse_url($redirect_back_url);
        $url_query = [];
        if (!empty($url_arr['query'])) {
            $url_query = explode('&', $url_arr['query']);
            // 微信自动加入参数过滤列表
            $wechat_query_except = [
                'from',
                'isappinstalled',
            ];
            // 开始过滤
            foreach ($url_query as $key=>$value) {
                $query_meta = explode('=', $value);
                if (in_array($query_meta[0], $wechat_query_except)) {
                    unset($url_query[$key]);
                }
                unset($query_meta);
            }
        }
        $redirect_back_uri = $url_arr['path'];
        if (!empty($url_query)) {
            $redirect_back_uri .= '?' . implode('&', $url_query);
        }
        // Log::debug(strlen($redirect_back_uri));
        unset($redirect_back_url,$url_arr);

        // 拼接授权重定向地址
        $zjtsw_server_url = config('app.zjtsw_server.base_url');
        // 暂定不带任何get参数
        // $auth_callback_url = config('app.url') . '/' . $request->expert_code . '/w/zjtsw?lu=' . $redirect_back_uri;
        $auth_callback_url = config('app.url') . '/' . $request->expert_code . '/w/zjtsw';
        $go_to_auth = $zjtsw_server_url . '/front/member/login?backurl=' . urlencode($auth_callback_url);

        return $go_to_auth;
    }
}
