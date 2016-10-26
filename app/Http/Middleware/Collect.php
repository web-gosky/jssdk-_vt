<?php

namespace App\Http\Middleware;

use Closure;

class Collect
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
        // 采集过滤特殊
        if ($this->_checkExpertCode($request)) {
            throw new HttpException(404);
        }

        return $next($request);
    }

    // 检测机构码合法性
    private function _checkExpertCode($request)
    {
        $expert_code = trim($request->expert_code);
        if(strlen($expert_code) < 2 || strlen($expert_code) > 32){
            return true;
        }

        return false;
    }

    // 检测地推码，存在即注入$request对象
    private function _checkAff($request)
    {
        if ($request->has('_aff')) {
            $_aff = trim($request->_aff);

            if(strlen($_aff) < 2 || strlen($_aff) > 32){
                return false;
            }
        }

        return true;
    }
}
