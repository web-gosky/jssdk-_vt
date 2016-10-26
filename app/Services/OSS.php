<?php

namespace App\Services;

use Illuminate\Http\Request;

use OSS\Http\RequestCore;
use OSS\Http\ResponseCore;
use OSS\OssClient;
use OSS\Core\OssException;

use App\Services\Api;
use App\Services\RequestClient;

use Config;
use Log;
use Storage;

class OSS
{
    private $ossClient;

    public function __construct($request)
    {
        $api = new Api($request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/alioss/get_sts_token',
            []
        );
        $this->sts_token = $api_res['return_value'];
        unset($api_res);
    }

    // OSS图片上传 二进制内容
    public function OSSImageUpload($file, $path, $option = 'weixin')
    {
        $file_name = date('YmdHis_') . uniqid() . '.jpg';
        $object = $path . '/' .  $file_name;
        $config = $this->sts_token;
        $ossClient = new OssClient($config['key_id'], $config['key_secret'], config('app.aliyun_oss.ossServerInternal'), false, $config['security_token']);
        try{
            if ($option == 'weixin') {
                $ossClient -> putObject($config['bucket'], $object, $file);
            }else{
                $ossClient -> uploadFile($config['bucket'], $object, $file);
            }
        } catch(OssException $e) {
            Log::debug($e->getMessage());
            return ;
        }

        $oss_result = [
            'flie_name' => $file_name,
            'object' => '/' . $object
        ];

        return $oss_result;
    }

    // OSS音频上传 二进制内容（微信）
    public function OSSAudioUpload($file, $path, $option = 'weixin')
    {
        $file_name = date('YmdHis_') . uniqid() . '.amr';

        // 处理格式转换，转换成mp3格式
        // Storage::put($file_name, $file);
        // $temp_file_path = config('filesystems.disks.local.root');
        // Log::debug([
        //     $file,
        //     $path,
        //     $temp_file_path
        // ]);

        // $request_client = new RequestClient();
        // $amr2mp3_url = config('app.service_server.base_url') . '/';
        // $post_data = [
            // 'amr_file' => '@' . $temp_file_path . '/' . $file_name
        //     'amr_file' => new \CURLFile($temp_file_path . '/' . $file_name),
        // ];

        // if (class_exists('\CURLFile')) {
        //     $post_data = ['amr_file' => new \CURLFile($temp_file_path . '/' . $file_name)];
        // } else {
        //     $post_data = ['amr_file' => '@' . $temp_file_path . '/' . $file_name];
        // }

        // $sound_file_mp3 = $request_client->post_file($amr2mp3_url, $post_data, []);
        // Log::debug($post_data);
        // unset($request_client, $amr2mp3_url, $post_data, $sound_file_mp3, $temp_file_path);

        $object = $path . '/' .  $file_name;
        $config = $this->sts_token;
        $ossClient = new OssClient($config['key_id'], $config['key_secret'], config('app.aliyun_oss.ossServerInternal'), false, $config['security_token']);
        try{
            if ($option == 'weixin') {
                $ossClient -> putObject(config('app.aliyun_oss.ossMediaBucket'), $object, $file);
            }else{
                $ossClient -> uploadFile(config('app.aliyun_oss.ossMediaBucket'), $object, $file);
            }
        } catch(OssException $e) {
            Log::debug($e->getMessage());
            return ;
        }

        $oss_result = [
            'flie_name' => $file_name,
            'object' => '/' . $object
        ];

        return $oss_result;
    }
}
