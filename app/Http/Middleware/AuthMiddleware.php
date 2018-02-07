<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午1:41
 */

namespace App\Http\Middleware;


use App\Providers\JWTService;
use Closure

class AuthMiddleware
{
	use JWTService;
	public function handle($request, Closure $next)
	{
		
	}
}