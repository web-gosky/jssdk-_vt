<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;

use App\Services\Wechat;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    // 请求实例
    protected $request;

    // 机构代码，从uri中解析而来。
    protected $expert_code;

    // 前端静态资源根目录，根据运行环境定义。
    // 图片资源
    protected $assets_path;
    // js,css,font等静态资源
    protected $assets_path_res;

    // 地推码。
    protected $_aff;

    // 地推码。
    protected $app_type;

    // http请求头
    protected $headers;

    public function __construct(Request $request)
    {
        //注入请求实例
        $this->request = $request;

        $this->expert_code = $request->expert_code;
        $this->_aff = $request->_aff;
        $this->headers = $this->_getHeaders();

        // 设置访问应用类型
        $this->_setAppType($this->request);

        // 向视图注入通用变量
        $this->_setViewShareData($this->request);
    }

    private function _setViewShareData($request)
    {
        // 向视图注入机构码。
        view()->share('expert_code', $this->expert_code);

        // 向视图注入静态资源路径前缀，开发环境为本地目录，生产环境根据需求配置。
        if (App::environment('dev', 'local')) {
            $this->assets_path = URL::asset('/') . 'assets/';
            $this->assets_path_res = URL::asset('/') . 'assets/';
        }else {
            $this->assets_path = config('app.aliyun_oss.img_host') . '/web/open/' . 'assets/';
            $this->assets_path_res = config('app.aliyun_oss.res_host') . '/web/open/' . 'assets/';
        }
        view()->share('assets_path', $this->assets_path);
        view()->share('assets_path_res', $this->assets_path_res);

        // 向视图注入地推码
        view()->share('_aff', $this->_aff);

        // 向视图注入JSSDK配置
        $wechat = new Wechat($request);
        $jssdk_config = $wechat->getJsConfig();
        view()->share('jssdk_config', $jssdk_config);
    }

    private function _setAppType($request)
    {
        $token_key = $request->header('token_key');
    }

    private function _getHeaders()
    {
        $headers = array();

        foreach($_SERVER as $key => $value) {
            if(substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                $key = strtolower($key);
                $key = str_replace('_', ' ', $key);
                $key = ucwords($key);
                $key = str_replace(' ', '-', $key);

                $headers[$key] = $value;
            }
        }

        return $headers;
    }
}
