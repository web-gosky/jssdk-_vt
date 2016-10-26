<?php

namespace App\Services;

class Api
{
    private $token_key;
    private $token_secret;
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
        $this->token_key = $this->request->session()->has('token_key')?$this->request->session()->get('token_key'):'';
        $this->token_secret = $this->request->session()->has('token_secret')?$this->request->session()->get('token_secret'):'';
    }

    public function getData($url, $post_data)
    {
        $response = $this->_httpRequest($url, $post_data);
        return $response;
    }

    private function _httpRequest($url, $post_data)
    {
        // 检测是否有地推码
        if ($this->request->has('_aff')) {
            $post_data['_aff'] = trim($this->request->_aff);
        }

        $header = [
            'Accept: application/json',
            'App-Version: 2000000',
            'App-Id: 3',
            'Network-Status: 3',
            'Channel-Name: open',
            'Resolution: 1080x1920',
            'Expert-Code: ' . $this->request->expert_code
        ];

        if (!empty($this->token_key) && !empty($this->token_secret)) {
            $header[] = 'Token-Key: ' . $this->token_key;
            $header[] = 'Token-Secret: ' . $this->token_secret;
        }

        $ch = curl_init();
        curl_setopt (
            $ch,
            CURLOPT_HTTPHEADER,
            $header
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        //接收数据时超时设置，如果20秒内数据未接收完，直接退出
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $api_data = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($http_code>=200 && $http_code<300)
        {
            $result = json_decode($api_data, true);
            if($result)
            {
                return $result;
            }
        }

        return false;
    }
}
