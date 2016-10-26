<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\Api;
use App\Services\RequestClient;

use Log;

use Illuminate\Support\Facades\Redis;

class Wechat
{
    // 请求实例
    private $request;

    public function __construct($request)
    {
        // 注入请求实例
        $this->request = $request;
    }

    // AJAX获取JS SDK配置
    public function getJsConfig()
    {
        $ticket_response = $this->_getJsTicket($this->request);

        $time = time();
        $nonceStr = $this->_createNonceStr();
        // 注意 URL 一定要动态获取，不能 hardcode.
        // $url = $this->request->fullUrl();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $params = [
            'jsapi_ticket' => $ticket_response['ticket'],
            'noncestr' => $nonceStr,
            'timestamp' => $time,
            'url' => $url
        ];
        ksort($params);
        $params_final = [];
        foreach ($params as $key => $value) {
            $params_final[] = $key . '=' . $value;
        }
        $signature_meta = implode('&', $params_final);
        $params['signature'] = sha1($signature_meta);
        unset($signature_meta);
        $params['appid'] = config('app.wechat.app_id');

        return $params;
    }

    public function getAccessToken()
    {
        $url = config('app.auth_server.base_url') . '/authwechat/getaccesstoken';
        $response_json = file_get_contents($url);
        $response_arr = json_decode($response_json, true);
        if(empty($response_arr['errcode'])){
            return $response_arr['access_token'];
        }else {
            return false;
        }
    }

    public function getMedia($media_id)
    {
        $normal_access_token = $this->getAccessToken();
        $response = false;
        if (!empty($normal_access_token)) {
            $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $normal_access_token . '&media_id=' . $media_id;
            $request_client = new RequestClient();
            $response = $request_client->get($url);

            $response_arr = json_decode($response, true);
            if (is_array($response_arr) && !empty($response_arr['errcode'])) {
                // 报错
                Log::debug([$normal_access_token, $media_id, $response_arr]);
                return false;
            }else {
                return $response;
            }
        }else {
            return false;
        }
    }

    // 获取jssdk_ticket
    private function _getJsTicket()
    {
        $jssdk_ticket = Redis::get(config('app.wechat.jssdk_ticket_key'));
        //查询是否已有jsapi_ticket记录
        if ($jssdk_ticket) {
            $jssdk_ticket_arr = json_decode($jssdk_ticket, true);
            return $jssdk_ticket_arr;
        }else{
            $response = $this->_flushJsTicket();

            return $response;
        }
    }

    // 重新从微信获取，并刷新jssdk_ticket
    private function _flushJsTicket()
    {
        $normal_access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='. $normal_access_token .'&type=jsapi';

        $request_client = new RequestClient();
        $response_json = $request_client->get($url);
        $response = json_decode($response_json, true);

        if(empty($response['ticket'])){
            // 抛出异常
        }else {
            // 存入缓存
            Redis::setex(config('app.wechat.jssdk_ticket_key'), ($response['expires_in'] - 3000), json_encode($response));
        }

        return $response;
    }

    private function _createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
