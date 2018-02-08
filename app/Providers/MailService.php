<?php
/**
 * Created by PhpStorm.
 * User: denverb
 * Date: 18/2/7
 * Time: 下午3:57
 */

namespace App\Providers;

/*
 * 邮件服务
 * 默认不开启
 * 根据env.mail_open判断是否开启邮件通知服务
 * */
use Illuminate\Support\Facades\Mail;

trait MailService
{
	public function sendMail($toUser, $content, $title)
	{
		Mail::raw($content, function ($message) use ($toUser, $title) {
			$message->to($toUser, 'DenverB')->subject($title);
		});
	}
}