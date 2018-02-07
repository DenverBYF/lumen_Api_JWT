<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午1:54
 */

namespace App\Http\Controllers;


use App\Providers\JWTService;
use Illuminate\Http\Request;

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

	}

	public function show($id)
	{

	}

	public function create()
	{

	}

	public function update($id)
	{

	}

	public function delete($id)
	{

	}

	public function like($id)
	{

	}

	public function comment($id)
	{

	}
}