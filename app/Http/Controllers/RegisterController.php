<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 上午11:16
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class RegisterController extends Controller
{
	public function index(Request $request)
	{
		try {			//数据检验
			$this->validate($request, [
				'name' => 'required|max:20|unique:users',
				'password' => 'required|min:6',
				'email' => 'required|email|unique:users',
			]);
		} catch (ValidationException $e) {
			return response()->json(['code' => -1, 'msg' => 'request data error', 'data' =>$e->response->original]);
		}
		$name = $request->get('name');
		$password = sha1($request->get('password'));
		$email = $request->get('email');

		$row = DB::table('users')->insert([
			'name' => $name,
			'password' => $password,
			'email' => $email
		]);

		if ($row) {
			return response()->json(['code' => 0, 'msg' => 'success']);
		} else {
			return response()->json(['code' => -1, 'msg' => 'fail']);
		}
	}
}