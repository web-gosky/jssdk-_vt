<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(
    [
        'prefix' => '{expert_code?}',
        'middleware' => 'collect',
    ],
    function () {

        /**
         * 微信授权路由组
         *
         */
        Route::group(
            [
                'middleware' => 'wechatauth',
            ],
            function () {
                /**
                 * 检测是否有小孩信息
                 *
                 */
                Route::group(
                    [
                        'middleware' => 'checkchild',
                    ],
                    function () {
                        // 首页
                        Route::match(['get', 'post'], '/familyread', 'IndexController@index');
                        Route::match(['get', 'post'], '/index', 'IndexController@index');
                        Route::match(['get', 'post'], '/index/index', 'IndexController@index');


                        // 上传页
                        Route::match(['get', 'post'], '/media', 'MediaController@index');
                        Route::match(['get', 'post'], '/media/index', 'MediaController@index');

                    }
                );

                /**
                 * 无需检测小孩信息
                 *
                 */
                 // 添加小孩页面
                 Route::match(['get', 'post'], '/wechatauth/addchild', 'WechatAuthController@addChild');

                 // 分享页
                 Route::match(['get', 'post'], '/share', 'ShareController@index');
                 Route::match(['get', 'post'], '/share/index', 'ShareController@index');

                 // 总榜页
                 Route::match(['get', 'post'], '/document', 'DocumentController@rankTopAll');
                 Route::match(['get', 'post'], '/document/ranktopall', 'DocumentController@rankTopAll');
                 // 周榜页
                 Route::match(['get', 'post'], '/document/ranktopweek', 'DocumentController@rankTopWeek');
                 // 奖励页
                 Route::match(['get', 'post'], '/document/rewards', 'DocumentController@rewards');

                 // 测试页
                 Route::match(['get', 'post'], '/document/test', 'DocumentController@test');
            }
        );

        /**
         * 无授权路由
         *
         */
        // 微信授权回调路由
        Route::match(['get', 'post'], '/wechatauth/gettoken', 'WechatAuthController@getToken');
        Route::match(['get', 'post'], '/w/g', 'WechatAuthController@getToken');

        // 青春浙江回调路由
        Route::match(['get', 'post'], '/wechatauth/zjtsw', 'WechatAuthController@getZjtsw');
        Route::match(['get', 'post'], '/w/zjtsw', 'WechatAuthController@getZjtsw');

        /**
         * api 接口
         *
         */
        // 首页api-1 获取活动详情
        Route::match(['get', 'post'], '/index/activitydetail', 'IndexController@activityDetail');
        // 首页api-2 获取精选列表及排行
        Route::match(['get', 'post'], '/index/activityessences', 'IndexController@activityEssences');
        // 上传页，上传保存媒体文件接口
        Route::match(['get', 'post'], '/media/upload', 'MediaController@saveMediaFile');

        // 验证并绑定手机接口
        Route::match(['get', 'post'], '/wechatauth/bindcellphone', 'WechatAuthController@bindCellPhone');
        // 发送验证码
        Route::match(['get', 'post'], '/wechatauth/sendcode', 'WechatAuthController@sendCode');
        // 对比验证码
        Route::match(['get', 'post'], '/wechatauth/checkcode', 'WechatAuthController@checkCode');

        // 保存小孩信息--接口
        Route::match(['get', 'post'], '/wechatauth/savechild', 'WechatAuthController@saveChild');

        // 分享页--点赞接口
        Route::match(['get', 'post'], '/share/like', 'ShareController@like');
    }
);
