<?php

namespace app\http\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        $token = $request->server('HTTP_TOKEN');
        if(!$token){
            header('HTTP/1.0 401 Unauthorized');
            header('Content-type: application/json');
            return renderData(10005);
            exit;
        }
 
        return $next($request);
    }
}
