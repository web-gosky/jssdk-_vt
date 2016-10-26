<?php

namespace App\Http\Controllers;

use Log;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\Wechat;
use App\Services\OSS;
use App\Services\Api;
use App\Services\RequestClient;

use Storage;

class MediaController extends Controller
{
    // 上传页面
    public function index()
    {
        $app_type = 'web';
        $app_type_list = ['web', 'ios', 'android'];
        if ($this->request->has('app_type') && in_array($this->request->input('app_type'), $app_type_list)) {
            $app_type = $this->request->input('app_type');
        }

        $api = new Api($this->request);
        // 启用计划并加入活动
        $children = $this->request->session()->get('children');
        $children_age = date('Y') - date('Y', strtotime($children['birthday']));
        $api_data['child_id'] = $children['child_id'];

        // 确定合适的套餐id
        if(CURR_ENV == 'local' || CURR_ENV == 'dev'){
            if($children_age >= 0 && $children_age <= 100) {
                $api_data['recommend_package_id'] = config('app.activity.recommend_package_id_anyway');
            }else {
                // 抛出异常
            }
        }else {
            if($children_age >= 0 && $children_age <= 6) {
                $api_data['recommend_package_id'] = config('app.activity.recommend_package_id_preschool');
            }elseif ($children_age >= 7 && $children_age <= 100) {
                $api_data['recommend_package_id'] = config('app.activity.recommend_package_id_inschool');
            }else {
                // 抛出异常
            }
        }

        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/enable_recommend_package',
            $api_data
        );
        if(!in_array($api_res['result_code'], [100000,120010])){
            // 抛出异常
        }
        $enable_info = $api_res['return_value'];
        unset($api_data, $api_res);

        // 获取上传记录
        $children = $this->request->session()->get('children');
        if (empty($enable_info['package_id']) || empty($children['child_id'])) {
            // 抛出异常
        }
        $api_data = [
            'package_id' => $enable_info['package_id'],
            'child_id' => $children['child_id'],
        ];
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_user_package_records',
            $api_data
        );
        // dump($api_res);
        $user_package_records = array_slice($api_res['return_value'], 0, 4, true);
        unset($api_data, $api_res);

        if ($app_type == 'ios') {
            // $app_type == 'ios'
            return view('media/ios_index', ['user_package_records' => $user_package_records]);
        }elseif ($app_type == 'android') {
            // $app_type == 'android'
            return view('media/android_index', ['user_package_records' => $user_package_records]);
        }else {
            // $app_type == 'web'
            return view('media/index', ['user_package_records' => $user_package_records]);
        }
    }

    public function saveMediaFile()
    {
        // 作语音处理
        if ($this->request->has('sound_media_id')) {
            $sound_media_id = trim($this->request->input('sound_media_id'));
            // Log::debug($sound_media_id);
            if (!empty($sound_media_id) && strlen($sound_media_id) > 0) {
                // 从微信服务器获取语音文件*.amr
                try {
                    $sound_file = $this->_getMedia($sound_media_id);
                    if (!$sound_file) {
                        throw new \Exception("上传失败！", 1);
                    }
                } catch (Exception $e) {
                    // Log::debug($e->getMessage());
                    $error_response = [
                        'status' => 10001,
                        'message' => '上传失败！',
                        'data' => [],
                        'timestamp' => time()
                    ];
                    return response()->json($error_response);
                }
                // 将语音文件发送转码服务进行转码
                $sound_file_name = date('YmdHis_') . uniqid() . '.amr';
                Storage::put($sound_file_name, $sound_file);
                $temp_file_path = config('filesystems.disks.local.root');
                $request_client = new RequestClient();
                $amr2mp3_url = config('app.service_server.base_url') . '/index';

                if (class_exists('\CURLFile')) {
                    $post_data = ['amr_file' => new \CURLFile($temp_file_path . '/' . $sound_file_name)];
                } else {
                    $post_data = ['amr_file' => '@' . $temp_file_path . '/' . $sound_file_name];
                }

                $sound_mp3_res = $request_client->post_file($amr2mp3_url, $post_data, []);
                Storage::delete($sound_file_name);

                $result['sound'] = json_decode($sound_mp3_res, true);
                $check_sound = true;
                unset($sound_file);
            }else {
                $result['sound'] = [
                    'flie_name' => '',
                    'object' => ''
                ];
                $check_sound = false;
            }
        }

        // 作图片处理
        if ($this->request->has('img_media_id')) {
            $img_media_id = trim($this->request->input('img_media_id'));
            // Log::debug($img_media_id);
            if (!empty($img_media_id) && strlen($img_media_id) > 0) {
                // 从微信服务器获取图片文件*.jpeg/jpg/png
                try {
                    $image_file = $this->_getMedia($img_media_id);
                } catch (Exception $e) {
                    // Log::debug($e->getMessage());
                    $error_response = [
                        'status' => 10002,
                        'message' => '上传失败！',
                        'data' => [],
                        'timestamp' => time()
                    ];
                    return response()->json($error_response);
                }

                // 将图片文件存入Aliyun-OSS
                $media_prefix_url = config('app.aliyun_oss.img_host');
                $path = config('app.aliyun_oss.ossindex');

                $oss = new OSS($this->request);
                $result['image'] = $oss->OSSImageUpload($image_file, $path, 'weixin');

                $check_image = true;
                unset($image_file, $media_prefix_url, $path, $oss);
            }else {
                $result['image'] = [
                    'flie_name' => '',
                    'object' => ''
                ];
                $check_image = false;
            }
        }

        // 语音和图片都不存在则返回失败，反之返回对应结果
        if ($check_sound = false && $check_image == false) {
            $error_response = [
                'status' => 10003,
                'message' => '上传失败！',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($error_response);
        }else {
            // 执行添加上传记录接口
            $api = new Api($this->request);
            // 获取对应的package_id
            $children = $this->request->session()->get('children');
            $children_age = date('Y') - date('Y', strtotime($children['birthday']));
            $api_data['child_id'] = $children['child_id'];

            // 确定合适的套餐id
            if(CURR_ENV == 'local' || CURR_ENV == 'dev'){
                if($children_age >= 0 && $children_age <= 100) {
                    $api_data['recommend_package_id'] = config('app.activity.recommend_package_id_anyway');
                }else {
                    // 抛出异常
                }
            }else {
                if($children_age >= 0 && $children_age <= 6) {
                    $api_data['recommend_package_id'] = config('app.activity.recommend_package_id_preschool');
                }elseif ($children_age >= 7 && $children_age <= 100) {
                    $api_data['recommend_package_id'] = config('app.activity.recommend_package_id_inschool');
                }else {
                    // 抛出异常
                }
            }

            $api_res = $api->getData(
                config('app.api_server.base_url') . '/v2/enable_recommend_package',
                $api_data
            );
            if(!in_array($api_res['result_code'], [100000,120010])){
                // 抛出异常
            }
            $enable_info = $api_res['return_value'];
            unset($api_data, $api_res, $children_age);

            // 配置默认图
            $default_photo_url = config('app.activity.default_photo_url');
            $api_data = [
                'package_id' => $enable_info['package_id'],
                'child_id' => $children['child_id'],
                'content' => '',
                'photo_url' => empty($result['image']['object'])?$default_photo_url:config('app.aliyun_oss.img_host') . $result['image']['object'],
                'audio_url' => empty($result['sound']['data']['oss_mp3_url'])?'':$result['sound']['data']['oss_mp3_url'],
                'video_url' => '',
            ];
            $api_res = $api->getData(
                config('app.api_server.base_url') . '/v2/add_user_package_record',
                $api_data
            );

            if ($api_res['result_code'] == 100000) {
                $response = [
                    'status' => 10000,
                    'message' => '操作成功',
                    'data' => [
                        'upr_id' => $api_res['return_value'] - 0
                    ],
                    'timestamp' => time()
                ];
                return response()->json($response);
            }else {
                $error_response = [
                    'status' => 10004,
                    'message' => '上传失败！' . $api_res['description'],
                    'data' => [],
                    'timestamp' => time()
                ];
                return response()->json($error_response);
            }
        }
    }

    // 获取媒体文件
    private function _getMedia($media_id)
    {
        $wechat = new Wechat($this->request);
        $file = $wechat->getMedia($media_id);
        return $file;
    }
}
