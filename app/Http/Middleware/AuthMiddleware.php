<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午1:41
 */

namespace App\Http\Middleware;


use App\Providers\JWTService;
use Closure;

/*
 * 用户身份验证中间件
 * */
class AuthMiddleware
{
	use JWTService;
	public function handle($request, Closure $next)
	{
		$token = $request->header('Authorization');
		if ($this->checkToken($token)) {
			return $next($request);
		} else {
			return response()->json(['code' => '-1', 'msg' => 'no login']);
		}
	}
}