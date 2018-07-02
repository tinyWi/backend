<?php
/**
 * desc   邮件
 * date   2016-01-19 10:58:51
 * author xupin
 **/
class Email {

	// phpEmail对象容器
	private static $__PHPemail;

	// email对象容器
	private static $__email;

	// 错误信息容器
	static $errorMessage;

	// 邮件插件配置信息
	static $host = 'smtp.exmail.qq.com';
	static $charSet = 'UTF-8';
	static $port = 465;
	static $userName = 'uea@uyegame.com';
	static $passWord = 'Youye20160513';
	static $form = 'uea@uyegame.com';
	static $formName = 'Uye Support';
	static $secure = 'ssl';

	// 发送邮件
	public static function postEmail( $to, $subject, $body){
		try {
			foreach (explode(';', $to) as $mail) {
				self::$__PHPemail->AddAddress($mail);
			}
			self::$__PHPemail->Subject = $subject;
			self::$__PHPemail->Body = $body;
			return self::$__PHPemail->Send();
		} catch (phpmailerException $e) {
			self::$errorMessage = $e->errorMessage();
			return false;
		}
	}

	// 邮件模板
	public static function checkCodeTemlate($username,$checkCode,$loginIP){
		$emailHeaderLogo = 'http://img.bimg.126.net/photo/6M3sShVuQQWLeO6jOMTXkA==/4230568899977957292.jpg';
		return <<<EOF
<table style="width: 538px; background-color: #393836;" align="center" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td style=" height: 65px; background-color: #000000; border-bottom: 1px solid #4d4b48;">
				  <img src="{$emailHeaderLogo}" width="538" height="65">
			</td>
		</tr>
		<tr>
			<td bgcolor="#17212e">
				<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left: 5px; padding-right: 5px; padding-bottom: 10px;">
					<tbody><tr bgcolor="#17212e">
						<td style="padding-top: 32px;">
						<span style="padding-top: 16px; padding-bottom: 16px; font-size: 24px; color: #66c0f4; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
							敬爱的 {$username}：
						</span><br>
						</td>
					</tr>
					<tr>
						<td style="padding-top: 12px;">
						<span style="font-size: 17px; color: #c6d4df; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
							<p>以下是您登录帐户 {$username} 时所需的 Uye 令牌验证码：</p>
						</span>
						</td>
					</tr>
					<tr>
						<td>
							<div>
								<span style="font-size: 24px; color: #66c0f4; font-family: Arial, Helvetica, sans-serif; font-weight: bold;"> {$checkCode} </span>
							</div>
						</td>
					</tr>
					<tr bgcolor="#121a25">
						<td style="padding: 20px; font-size: 12px; line-height: 17px; color: #c6d4df; font-family: Arial, Helvetica, sans-serif;">
								<p style="padding-bottom: 10px; color: #c6d4df;">这封电子邮件生成是由于地址为 <a style="color: #c6d4df;" href="javascript:void(0);">{$loginIP}（CN）</a>的电脑试图登录您的帐户。该地址在试图登录时输入了您正确的帐户名称和密码。</p>
								<p style="padding-bottom: 10px; color: #c6d4df;">要完成登录，您需要 Uye 令牌验证码。<span style="color: #ffffff; font-weight: bold;">无人可以在不访问这封电子邮件的前提下访问您的帐户。</span></p>
								<p style="padding-bottom: 10px; color: #c6d4df;"><span style="color: #ffffff; font-weight: bold;">如果您未曾试图登录</span>，请更改您的 Uye 密码，并考虑更改您的电子邮件密码，确保您的帐户安全。</p>
								<p style=" padding-top: 10px; color: #61696d">如果您无法访问您的帐户，那么可以<a style="color: #8f98a0;" href="javascript:void(0);">使用该帐户专用救援链接</a>以获得救援或自行锁定您的帐户的协助。</p>
						</td>
					</tr>
					<tr>
						<td style="font-size: 12px; color: #6d7880; padding-top: 16px; padding-bottom: 60px;">
									Uye 客服团队<br>
									<a style="color: #8f98a0;" href="javascript:void(0);">暂时没有</a><br>
						</td>
					</tr>
				</tbody></table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#000000">
				<table width="460" height="55" border="0" align="center" cellpadding="0" cellspacing="0">
				 <tbody><tr valign="top">
				  <td width="350" valign="top">
				   <span style="color: #999999; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">© Uye Corporation. 保留所有权利。所有商标均为其在中国及其它国家/地区的各自持有者所有。</span>
				  </td>
				 </tr>
				</tbody></table>
			</td>
		</tr>
		<tr>
		</tr>
	</tbody>
</table>
EOF;
	}

	// 创建连接email对象
	static public function connect(){
		if(!(self::$__PHPemail instanceof PHPMailer)){
			self::$__PHPemail = new PHPMailer(true);
			self::$__PHPemail->IsSMTP();
			self::$__PHPemail->CharSet = self::$charSet; //设置邮件的字符编码，这很重要，不然中文乱码
			self::$__PHPemail->SMTPAuth = true; //开启认证
			self::$__PHPemail->SMTPSecure = self::$secure;
			// self::$__PHPemail->SMTPDebug = 1; // debug
			self::$__PHPemail->Port = self::$port;
			self::$__PHPemail->Host = self::$host;
			self::$__PHPemail->Username = self::$userName;
			self::$__PHPemail->Password = self::$passWord;
			// self::$__PHPemail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示
			self::$__PHPemail->AddReplyTo( self::$userName, 'reply');//回复地址
			self::$__PHPemail->From = self::$form;
			self::$__PHPemail->FromName = self::$formName;
			self::$__PHPemail->Encoding = 'base64';
			self::$__PHPemail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; //当邮件不支持html时备用显示，可以省略
			self::$__PHPemail->WordWrap = 80; // 设置每行字符串的长度
			// self::$__PHPemail->AddAttachment("f:/test.png"); //可以添加附件
			self::$__PHPemail->IsHTML(true);
		}
		if(!(self::$__email instanceof Email)){
			self::$__email = new Email;
		}
		return self::$__email;
	}

	// 获取报错信息
	public static function getError(){
		return self::$errorMessage;
	}
}