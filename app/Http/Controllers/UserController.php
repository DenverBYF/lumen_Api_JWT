<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午3:18
 */

namespace App\Http\Controllers;


use App\Providers\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	use JWTService;
	public function index()
	{
		$users = DB::table('users')->select(['id', 'name', 'email'])->get();
		$ret = [];
		foreach ($users as $eachUser) {
			$postNum = DB::table('posts')->where('uid', $eachUser->id)->count();	//文章数
			$eachUser = json_decode(json_encode($eachUser), true);		//转数组
			$ret[] = array_merge($eachUser, ['postNum' => $postNum]);
		}
		return response()->json(['code' => 0, 'msg' => 'success', 'data' => $ret]);
	}

	public function show($id)
	{
		$user = DB::table('users')->select(['id', 'name', 'email'])->where('id', $id)->first();
		if (empty($user)) {
			return response()->json(['code' => -1, 'msg' => 'not found this user']);
		}
		$posts = DB::table('posts')->select(['id', 'title'])->where('uid', $user->id)->get();
		$posts = json_decode(json_encode($posts), true);
		return response()->json([
			'code' => 0,
			'msg' => 'success',
			'data' => array_merge(['user' => $user], ['posts' => $posts])
		]);
	}

	public function follow(Request $request, $id)
	{
		$user = $this->getUser($request->header('Authorization'));
		DB::table('users')->increment('follow', 1, ['id' => $id]);
		$row = DB::table('follow')->insert([
			'fid' => $id,
			'uid' => $user->id
		]);
		if ($row) {
			return response()->json(['code' => 0, 'msg' => 'success']);
		} else {
			return response()->json(['code' => -2, 'msg' => 'fail']);
		}
	}
}