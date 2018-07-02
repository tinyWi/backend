<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联运平台 - 注册</title>
    <meta name="keywords" content="游曳联合运营平台">
    <meta name="description" content="游曳联合运营平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">Uye</h1>

            </div>
            <h3>欢迎注册 Uye</h3>
            <p>创建一个Uye新账户</p>
            <form class="m-t" role="form" method="post" action="<?php echo yii::app()->createUrl('Index/Register');?>">
				<div class="form-group">
                    <input type="text" name="username" value="<?php echo $username;?>" class="form-control" placeholder="请输入用户名" required="required">
                </div>
				<div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="请输入邮箱" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="请输入密码" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control" placeholder="请再次输入密码" required="required">
                </div>
				<!--
                <div class="form-group text-left">
                    <div class="checkbox i-checks">
                        <label class="no-padding">
						<input type="checkbox"><i></i> 我同意注册协议</label>
                    </div>
                </div>
				-->
                <button type="button" class="btn btn-primary block full-width m-b">注 册</button>
				<input type="hidden" name="register" value="1"/>
                <p class="text-muted text-center"><small>已经有账户了？</small><a href="<?php echo yii::app()->createUrl('Index/Login');?>">点此登录</a>
                </p>
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>
	
	<!-- layer javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>
	
	<!-- iCheck
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
	-->
	
	<!-- 自定义 -->
	<script>
		$(function () {
			$("button").click(function(){
				if(!$("input[name='email']").val()){
					//tips层
					layer.tips('亲，邮箱要确保真实性喔~', "input[name='email']");
					$("input[name='email']").focus();
					return;
				}
				if(!$("input[name='username']").val()){
					//tips层
					layer.tips('亲，用户名还是要填的哟~', "input[name='username']");
					$("input[name='username']").focus();
					return;
				}
				if(!$("input[name='password']").val()){
					//tips层
					layer.tips('亲，有名没密码怎么可以~', "input[name='password']");
					$("input[name='password']").focus();
					return;
				}
				if( !$("input[name='confirm_password']").val() 
					|| $("input[name='password']").val() != $("input[name='confirm_password']").val()){
					//tips层
					layer.tips('亲，确认两次密码保持一致~', "input[name='confirm_password']");
					$("input[name='confirm_password']").focus();
					return;
				}
                $.get("<?php echo yii::app()->createUrl('Ajax/UserIsValid');?>",{username: $("input[name='username']").val(), email: $("input[name='email']").val()},function(data){
                    if(<?php echo Consts::USER_EMAIL_USED?> == data.status
                        || <?php echo Consts::USER_EMAIL_NOTFOUND?> == data.status){
                        //tips层
                        layer.tips(data.msg, "input[name='email']");
                        $("input[name='email']").focus();
                        return;
                    }else if(<?php echo Consts::USER_STATUS_ONLINE?> == data.status){
                        //tips层
                        layer.tips(data.msg, "input[name='username']");
                        $("input[name='username']").focus();
                        return;
                    }
                    register();
                },"json");
			});
		});
        function register(){
            $("form").submit();
        }
	</script>
</body>

</html>