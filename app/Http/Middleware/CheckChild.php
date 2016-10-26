<?php

namespace App\Http\Middleware;

use Closure;

class CheckChild
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
        if(!$this->_isChild($request)){
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                // 没手机就跳转绑定手机
                if (!$this->_isChild($request)) {
                    if ($request->expert_code == 'zhejiangtsw') {
                        return redirect($request->expert_code . '/wechatauth/addchild');
                    }else {
                        return redirect($request->expert_code . '/wechatauth/bindcellphone');
                    }
                }else {
                    // 没有小孩跳转添加小孩
                    return redirect($request->expert_code . '/wechatauth/addchild');
                }
            }
        }
        return $next($request);
    }

    private function _isChild($request)
    {
        $children = $request->session()->get('children');
        if (is_array($children) && !empty($children)) {
            return true;
        }

        return false;
    }

    private function _isCellPhone($request)
    {
        $cellphone = $request->session()->get('cellphone');
        if (!empty($cellphone)) {
            return true;
        }

        return false;
    }
}
