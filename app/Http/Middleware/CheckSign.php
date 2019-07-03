<?php

namespace App\Http\Middleware;

use App\Http\Common\Encryption;
use Closure;

class CheckSign
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
        
        Encryption::checkSign($request->all());
        
        //把_sign字段去掉，一定得去掉！！
        $request->offsetUnset('_sign');
        
        return $next($request);
    }
}
