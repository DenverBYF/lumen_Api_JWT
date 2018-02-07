<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午12:10
 */

namespace App\Providers;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

trait JWTService
{
	public function getToken($id) {
		$sign = new Sha256();
		$token = (new Builder())->setIssuer(env('JWT_ISS'), 'CTG') // 签发者
		->setAudience(env('JWT_Audience', 'CTG'))// 接受者
		->setId(env('JWT_ID', '123456abc'), true) // 唯一身份标识
		->setIssuedAt(time()) // 签发时间
		->setExpiration(time() + 3600*24) // 过期时间
		->set('uid', $id) // 公开声明,用户id
		->sign($sign, env('JWT_SIGN', 'CTG'))	//签名认证
		->getToken(); // Retrieves the generated token
		return $token;
	}

	public function checkToken($token) {
		$data = new ValidationData();
		$data->setIssuer(env('JWT_ISS', 'CTG'));
		$data->setAudience(env('JWT_Audience', 'CTG'));
		$data->setId(env('JWT_ID', '123456abc'));
		try {
			$token = (new Parser())->parse((string) $token);    //获取JWT token
		} catch (Exception $e) {
			return false;
		}
		$sign = new Sha256();
		if ($token->verify($sign, env('JWT_SIGN', 'CTG'))) {		//验证签名
			if ($token->validate($data)) {			//验证token
				return $token->getClaim('uid');		//返回用户id
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}