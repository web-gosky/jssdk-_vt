<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\Api;
use Log;

class ShareController extends Controller
{
    // 分享页
    public function index()
    {
        if (!$this->request->has('upr_id')) {
            return response('没有分享id', 404);
        }
        $upr_id = $this->request->input('upr_id');

        $is_share = false;

        // 获取api数据
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_user_package_record_liked_members',
            [
                'upr_id' => $upr_id,
            ]
        );
        $like_users = [];
        if (!empty($api_res['result_code']) && $api_res['result_code'] == 100000) {
            // api请求成功
            $like_users = !empty($api_res['return_value'])?$api_res['return_value']:[];
        }else {
            // api请求错误
            $api_res['api'] = config('app.api_server.base_url') . '/v2/get_user_package_record_liked_members';
            Log::debug($api_res);
        }
        unset($api_res);

        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_user_package_record_detail',
            [
                'upr_id' => $upr_id,
            ]
        );
        $upr_detail = [];
        if (!empty($api_res['result_code']) && $api_res['result_code'] == 100000 && !empty($api_res['return_value'])) {
            // api请求成功
            $upr_detail = [
                'upr_id' => $api_res['return_value']['upr_id'] - 0,
                'child_id' => $api_res['return_value']['child_id'] - 0,
                'tag' => $api_res['return_value']['tag'],
                'content' => $api_res['return_value']['content'],
                'photo_url' => $api_res['return_value']['photo_url'],
                'audio_url' => $api_res['return_value']['audio_url'],
                'video_url' => $api_res['return_value']['video_url'],
                'integer_count' => $api_res['return_value']['integer_count'] - 0,
                'activity_id' => $api_res['return_value']['activity_id'] - 0,
                'all_integer' => $api_res['return_value']['all_integer'] - 0,
                'child_nickname' => $api_res['return_value']['child_nickname'],
                'child_avatar_url' => $api_res['return_value']['child_avatar_url']
            ];
            // 检测是否是自己打开分享页
            // if ($this->request->has('is_share') && $this->request->input('is_share') == 1) {
            //     $is_share = true;
            // }
            if ($this->request->session()->has('children')) {
                $children = $this->request->session()->get('children');
                if (!empty($children['child_id']) && $children['child_id'] == $upr_detail['child_id']) {
                    $is_share = true;
                }
            }
        }else {
            // api请求错误
            $api_res['api'] = config('app.api_server.base_url') . '/v2/get_user_package_record_detail';
            Log::debug($api_res);
            return response('没有详情', 404);
        }
        unset($api_res);

        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_activity_detail',
            [
                'activity_id' => config('app.activity.activity_id'),
            ]
        );
        $activity_detail = [];
        if (!empty($api_res['result_code']) && $api_res['result_code'] == 100000 && !empty($api_res['return_value'])) {
            // api请求成功
            $activity_detail = [
                'activity_id' => $api_res['return_value']['activity_id'] - 0,
                'name' => $api_res['return_value']['name'],
                'icon_url' => $api_res['return_value']['icon_url'],
                'homepage_url' => $api_res['return_value']['homepage_url'],
                'member_url' => $api_res['return_value']['member_url'],
                'share_url' => $api_res['return_value']['share_url'],
                'integer_count' => $api_res['return_value']['integer_count'] - 0,
                'member_count' => $api_res['return_value']['member_count'] - 0,
                'is_join' => $api_res['return_value']['is_join'] - 0
            ];
        }else {
            // api请求错误
            $api_res['api'] = config('app.api_server.base_url') . '/v2/get_activity_detail';
            Log::debug($api_res);
            return response('没有活动详情', 404);
        }
        unset($api_res);

        $join_url = config('app.url') . '/' . $this->expert_code . '/media/index';
        $view_data = [
            'activity_detail' => $activity_detail,
            'upr_detail' => $upr_detail,
            'like_users' => $like_users,
            'join_url' => $join_url,
            'member_info' => $this->request->session()->get('member_info'),
        ];

        if (!$is_share) {
            return view('share/index', $view_data);
        }else {
            return view('share/index_self', $view_data);
        }
    }

    // 分享点赞接口
    public function like()
    {
        if (!$this->request->has('upr_id')) {
            $error_response = [
                'status' => 10001,
                'message' => '缺少参数',
                'data' => [],
                'timestamp' => time()
            ];
            return response()->json($error_response);
        }
        $api_data = [
            'upr_id' => $this->request->input('upr_id')
        ];

        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/user_package_record_like',
            $api_data
        );
        // var_dump($detail);exit;

        if ($api_res['result_code'] == 100000) {
            $error_response = [
                'status' => 10000,
                'message' => '操作成功',
                'data' => $api_res['return_value'],
                'timestamp' => time()
            ];
            $api_res['api'] = config('app.api_server.base_url') . '/v2/user_package_record_like';
            Log::debug($api_res);
            return response()->json($error_response);
        }else {
            $error_response = [
                'status' => 20004,
                'message' => '点赞失败',
                'data' => $result['return_value'],
                'timestamp' => time()
            ];
            return response()->json($error_response);
        }
    }
}
