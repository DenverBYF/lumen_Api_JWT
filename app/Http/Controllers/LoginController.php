<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午12:05
 */

namespace App\Http\Controllers;


use App\Providers\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
	use JWTService;
	public function index(Request $request)
	{
		try {
			$this->validate($request, [        //数据检验
				'password' => 'required|min:6',
				'email' => 'required|email',
			]);
		} catch (ValidationException $e) {
			return response()->json([
				'code' => -1,
				'msg' => 'request data error',
				'data' =>$e->response->original
			]);
		}
		$email = $request->get('email');
		$password = sha1($request->get('password'));
		$user = DB::table('users')->select(['password', 'id'])->where('email', $email)->first();
		if ($user->password === $password) {
			$token = $this->getToken($user->id);		//用该用户的唯一id获取JWT的token对象
			$token = (string) $token;					//获取token的字符串值
			return response()->json(['code' => 0,
				'msg' => 'success',
				'data' => ['token' => $token]		//返回token值
			]);
		} else {
			return response()->json(['code' => 0, 'msg' => 'password wrong']);
		}
	}
}