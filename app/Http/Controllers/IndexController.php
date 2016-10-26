<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Api;

use App\Http\Requests;

use Illuminate\Support\Facades\Redis;

use App\Services\OSS;

class IndexController extends Controller
{
    public function index()
    {
        // 拼装一键加入套餐链接join_url
        $join_url = config('app.url') . '/' . $this->expert_code . '/media/index';

		if($this->request->expert_code == 'zhejiangtsw'){
			return view('index/index_zjtsw', ['join_url' => $join_url]);
		}

		return view('index/index', ['join_url' => $join_url]);
    }

    // 首页api-2 获取精选列表
    public function activityEssences()
    {
        $post_data = [
            'get_type' => 1,
            'page_index' => 1,
            'page_size' => 30
        ];
        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_user_package_records_essence_by_activity',
            $post_data
        );
        $activity_essences = $api_res['return_value'];
        unset($post_data, $api_res);

        $post_data = ['activity_id' => config('app.activity.activity_id')];
        $post_data['record_quantity'] = 10;
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_activity_top_child',
            $post_data
        );
        $activity_top_child = $api_res['return_value'];
        unset($api_res);

        $time = time();
        $post_data['year'] = intval( date('Y', $time) );
        $post_data['week'] = intval( date('W', $time) );
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_activity_top_child_by_week',
            $post_data
        );
        $activity_top_child_by_week = $api_res['return_value'];
        unset($api_res);

        if ($activity_essences['objects'] && $activity_top_child && $activity_top_child_by_week) {
            return response()->json([
                'status' => 10000,
                'message' => '操作成功',
                'data' => [
                    'top_all' => $activity_top_child,
                    'top_week' => $activity_top_child_by_week,
                    'record' => $activity_essences['objects'],
                    'rule_url' => $this->expert_code . '/document/rewards',
                ],
                'timestamp' => time()
            ]);
        }else {
            return response()->json([
                'status' => 20000,
                'message' => '获取数据失败',
                'data' => [],
                'timestamp' => time()
            ]);
        }
    }

    // 首页api-1 获取活动详情及排行
    public function activityDetail()
    {
        $post_data = ['activity_id' => config('app.activity.activity_id')];

        $api = new Api($this->request);
        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_activity_detail',
            $post_data
        );
        $activity_detail = $api_res['return_value'];
        unset($api_res);

        $api_res = $api->getData(
            config('app.api_server.base_url') . '/v2/get_enable_activity_milestone_by_activity',
            $post_data
        );
        $milestone_detail = $api_res['return_value'];
        $milestone_detail['milestone_integer'] = $milestone_detail['milestone_integer']%1000000;
        unset($api_res);

        if ($activity_detail && $milestone_detail) {
            return response()->json([
                'status' => 10000,
                'message' => '操作成功',
                'data' => [
                    'detail' => $activity_detail,
                    'milestone' => $milestone_detail,
                ],
                'timestamp' => time()
            ]);
        }else {
            return response()->json([
                'status' => 20000,
                'message' => '获取数据失败',
                'data' => [],
                'timestamp' => time()
            ]);
        }

    }
}
