<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title><?php echo Yii::app()->params['name']; ?> - 登录</title>

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">Uye</h1>
            </div>
            <h3>欢迎使用 Uye</h3>
            <form class="m-t" role="form" method="post" action="<?php echo yii::app()->createUrl('Index/Login');?>">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="用户名" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="required">
                </div>
                <button type="button" class="btn btn-primary block full-width m-b">登 录</button>
				<input type="hidden" name="login" value="1"/>
                <p class="text-muted text-center"> <a href="javascript:void(0);"><small>忘记密码了？</small></a> | <a href="<?php echo yii::app()->createUrl('Index/Register');?>">注册一个新账号</a>
                </p>
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>
	
	<!-- layer javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>
	
	<!-- Jquery MD5 -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery.md5.js"></script>
	
	<!-- 自定义 -->
	<script>
		$(function () {
			// 用户名光标
			$("input[name='username']").focus();
			// temp
			$("a:first").click(function(){
				//tips层
				layer.tips('该功能暂未开放！', "a:first", {tips: [3, '#3595CC']});
				return;
			});
			// 表单验证
			$("button").click(function(){
				loginCheckInfo();
			});
		});
		// 检查登录信息
		function loginCheckInfo(){
			if(!$("input[name='username']").val()){
				//tips层
				layer.tips('请填写用户名?', "input[name='username']");
				$("input[name='username']").focus();
				return;
			}
			if(!$("input[name='password']").val()){
				//tips层
				layer.tips('请填写密码！', "input[name='password']");
				$("input[name='password']").focus();
				return;
			}
			$("button").text("正在验证");
			$.post("<?php echo yii::app()->createUrl('Ajax/LoginCheckInfo');?>",{username: $("input[name='username']").val(), password: $.md5($("input[name='password']").val())},function(data){
				if(<?php echo Consts::USER_NOTFOUND;?> == data.status){
					alert(data.msg);
					window.location.href="<?php echo $this->createUrl('Index/Register');?>?username=" + $("input[name='username']").val();
				}else if(<?php echo Consts::USER_STATUS_FREEZE;?> == data.status){
					alert(data.msg);
				}else if(<?php echo Consts::USER_INFO_RIGHT;?> == data.status){
					loginCheckIP();
					setInterval(loginCheckIP,4000);
					loginCheckCode();
				}else if(<?php echo Consts::USER_PASSWORD_ERROR;?> == data.status){
					layer.tips('密码不正确！', "input[name='password']");
					$("input[name='password']").attr("type", "text");
					$("button").text("登录");
					return;
				}else if(<?php echo Consts::USER_WAIT_CHECK;?> == data.status){
					alert(data.msg);
					window.location.href="<?php echo $this->createUrl('Index/Login');?>";
				}
			},"json");
		}
		// 检查IP
		function loginCheckIP(){
			$.post("<?php echo yii::app()->createUrl('Ajax/LoginCheckIp');?>",{username: $("input[name='username']").val()},function(data){
				if(<?php echo Consts::USER_STATUS_ONLINE;?> == data.status){
					layer.closeAll('iframe');
					$("button").attr("disabled","disabled");
					$("button").text("正在登录");
					setTimeout(login,3000);
				}
			},"json");
		}
		// 检查验证码
		function loginCheckCode(){
			$.post("<?php echo yii::app()->createUrl('Ajax/LoginCheckIp');?>",{username: $("input[name='username']").val()},function(data){
				if(<?php echo Consts::USER_STATUS_PAUSE;?> == data.status){
					parent.layer.open({
						type: 2,
						title: 'Uye验证页',
						shadeClose: true,
						shade: 0.9,
						area: ["378px", "279px"],
						content: '<?php echo yii::app()->createUrl('Index/CheckCode');?>' // iframe的url
					});
				}
			},"json");
		}
		// 提交表单
		function login(){
			$("form").submit();
		}
		// 回车事件
		document.onkeydown = function(event){
			var e = event || window.event || arguments.callee.caller.arguments[0];           
			if(e && e.keyCode == 13){ // enter键
				loginCheckInfo();
			}
		};
	</script>
</body>

</html>