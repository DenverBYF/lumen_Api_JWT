<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午12:10
 */

namespace App\Providers;


use Illuminate\Support\Facades\DB;

/*
 * 文章CURD
 * */
class PostService
{
	protected $post;
	public function __construct($id = null)
	{
		$this->id = $id;	//文章唯一id
	}

	public function find()
	{
		$post = DB::table('posts')->where('id', $this->id)->first();
		DB::table('posts')->increment('view', 1, ['id' => $this->id]);		//添加浏览量
		return $this->jsonReturn($post);
	}

	public function create($data)
	{
		$id = DB::table('posts')->insertGetId($data);
		if ($id) {
			return $this->jsonReturn(['id' => $id]);
		} else {
			return $this->errorReturn();
		}
	}

	public function delete()
	{
		$row = DB::table('posts')->where('id', $this->id)->delete();
		if ($row) {
			return $this->jsonReturn();
		} else {
			return $this->errorReturn();
		}
	}

	public function update($data)
	{
		$row = DB::table('posts')->where('id', $this->id)->update($data);
		if ($row) {
			return $this->jsonReturn(['id' => $this->id]);
		} else {
			return $this->errorReturn();
		}
	}

	//点赞
	public function like($uid)
	{
		DB::table('posts')->increment('like', 1, ['id' => $this->id]);
		$row = DB::table('like')->insert([
			'pid' => $this->id,
			'uid' => $uid
		]);
		if ($row) {
			return $this->jsonReturn(['id' => $this->id]);
		} else {
			return $this->errorReturn();
		}
	}

	public function comment($data)
	{
		DB::table('posts')->increment('comment', 1, ['id' => $this->id]);
		$row = DB::table('comments')->insert($data);
		if ($row) {
			return $this->jsonReturn(['id' => $this->id]);
		} else {
			return $this->errorReturn();
		}
	}

	protected function jsonReturn($data = [], $code = 0, $msg = 'success')
	{
		return response()->json(['code' => $code, 'msg' => $msg, 'data' => $data]);
	}

	protected function errorReturn($code = -2, $msg = 'fail')
	{
		return response()->json(['code' => $code, 'msg' => $msg]);
	}

}