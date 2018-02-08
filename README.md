# lumen_Api_JWT
使用lumen开发的极简博客Api，利用JWT进行用户认证

### 环境要求:
php 7+
composer
mysql
openssl_extension
### 使用
`git clone https://github.com/DenverBYF/lumen_Api_JWT.git`
`composer install`
`cp .env.example .env`
配置.env文件，配置数据库信息，如果需要开启邮件通知服务，需配置MAIL_OPEN=1，并配置相关邮件信息。配置JWT相关信息(随意写)。
```
MAIL_OPEN=0		//默认不开启邮件功能  MAIL_DRIVER=smtp
 MAIL_HOST=smtp.mailtrap.io
 MAIL_PORT=2525
 MAIL_USERNAME=null
 MAIL_PASSWORD=null
 MAIL_ENCRYPTION=null
 MAIL_FROM_ADDRESS=
 JWT_ISS=		//JWT签发者
 JWT_Audience=	//JWT接受者
 JWT_ID=			//JWT唯一ID
 JWT_SIGN=		//签名

```

###功能
注册，登录，文章CURD，评论，点赞，关注，邮件通知（文章收到点赞，评论，收到用户关注时发送通知）

###待完善
加缓存，邮件发送异步队列等

###Api文档
[Api文档链接](http://showdoc.fenlan96.com/index.php?s=/13)


