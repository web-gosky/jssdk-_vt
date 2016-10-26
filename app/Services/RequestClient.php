<?php

namespace App\Services;

use Log;

class RequestClient
{
    public function __construct()
    {
    }

    public function get($url, $headers = [])
    {
        $response = $this->_httpRequestGet($url, $headers);

        return $response;
    }

    public function post($url, $post_data, $headers = [])
    {
        $response = $this->_httpRequestPost($url, $post_data, $headers);

        return $response;
    }

    public function post_file($url, $post_data, $headers = [])
    {
        $response = $this->_httpRequestPostFile($url, $post_data, $headers);

        return $response;
    }

    private function _httpRequestGet($url, $headers)
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //接收数据时超时设置，如果20秒内数据未接收完，直接退出
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        //执行并获取HTML文档内容
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //释放curl句柄
        curl_close($ch);

        if($http_code>=200 && $http_code<300)
        {
            return $response;
        }else {
            return false;
        }
    }

    private function _httpRequestPost($url, $post_data, $headers = [])
    {
        $ch = curl_init();
        if(empty($headers)){
            curl_setopt ($ch, CURLOPT_HTTPHEADER, []);
        }else {
            curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        //接收数据时超时设置，如果20秒内数据未接收完，直接退出
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($http_code>=200 && $http_code<300)
        {
            return $response;
        }else {
            return false;
        }
    }

    private function _httpRequestPostFile($url, $post_data, $headers = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, false);
        //启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        // curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        if (class_exists('\CURLFile')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        //相当关键，这句话是让curl_exec($ch)返回的结果可以进行赋值给其他的变量进行，json的数据操作，如果没有这句话，则curl返回的数据不可以进行人为的去操作（如json_decode等格式操作）
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($http_code>=200 && $http_code<300)
        {
            return $response;
        }else {
            return false;
        }
    }
}
