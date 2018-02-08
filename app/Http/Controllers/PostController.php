<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午1:54
 */

namespace App\Http\Controllers;


use App\Providers\JWTService;
use App\Providers\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
	use JWTService;

	protected $user, $request;	//当前用户
	public function __construct(Request $request)
	{
		if ($token = $request->header('Authorization')) {
			$this->user = $this->getUser($token);
		}
		$this->request = $request;
	}

	public function index()
	{
		$posts = DB::table('posts')->select(['id', 'title', 'content', 'view', 'uid', 'like'])->get();
		return response()->json(['code' => 0, 'msg' => 'success', 'data' => $posts]);
	}

	public function show($id)
	{
		$postService = new PostService($id);
		return $postService->find();
	}

	public function create()
	{
		try {
			$this->validate($this->request, [        //数据检验
				'title' => 'required|max:30',
				'content' => 'required',
			]);
		} catch (ValidationException $e) {
			return response()->json([
				'code' => -3,
				'msg' => 'request data error',
				'data' =>$e->response->original
			]);
		}
		$postService = new PostService(null);
		return $postService->create(array_merge($this->request->all(), ['uid' => $this->user->id]));
	}

	public function update($id)
	{
		if ($this->judge($id)) {
			return response()->json(['code' => -3, 'msg' => 'not writer of this article']);
		}
		try {
			$this->validate($this->request, [
				'title' => 'max:30',
			]);
		} catch (ValidationException $e) {
			return response()->json([
				'code' => -3,
				'msg' => 'request data error',
				'data' =>$e->response->original
			]);
		}
		$postService = new PostService($id);
		return $postService->update($this->request->all());
	}

	public function delete($id)
	{
		if ($this->judge($id)) {
			return response()->json(['code' => -3, 'msg' => 'not writer of this article']);
		}
		$postService = new PostService($id);
		return $postService->delete();
	}

	public function like($id)
	{
		$postService = new PostService($id);
		return $postService->like($this->user->id);
	}

	public function comment($id)
	{
		try {
			$this->validate($this->request, [
				'content' => 'max:30',
			]);
		} catch (ValidationException $e) {
			return response()->json([
				'code' => -3,
				'msg' => 'request data error',
				'data' =>$e->response->original
			]);
		}
		$postService = new PostService($id);
		return $postService->comment(array_merge(['uid' => $this->user->id, 'pid' => $id], $this->request->all()));
	}

	protected function judge($id)
	{
		$uid = DB::table('posts')->select('uid')->where('id', $id)->first();
		return $uid->uid !== $this->user->id;
	}
}