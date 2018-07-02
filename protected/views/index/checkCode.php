<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">

</head>

<body class="gray-bg">
	<?php if(!$isCheck):?>
    <div class="modal-content">
		<div class="modal-body">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="m-t-none m-b">登录</h3>

					<p>由于系统检测到您的账号从未在此台设备登陆过</p>
					
					<p>系统将会发送验证码到您的电子邮箱中(⊙o⊙)</p>
					
					<form role="form" method="post" action="<?php echo yii::app()->createUrl('Index/CheckCode');?>">
						<div class="form-group">
							<label>验证码：</label>
							<input type="text" name="code" placeholder="请输入验证码" class="form-control" required="required">
						</div>
						<div>
							<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button">
								<strong>验证</strong>
							</button>
							<label style="color: red; font-size: 12px;"><?php echo $checkMsg;?></label>
							<input type="hidden" name="check" value="1"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php endif;?>
	<?php if($isCheck):?>
	<div style="text-align: center; color: blue; font-size:15px; padding-top: 50px;"><label class="checkStatus">正在验证...</label></div>
	<div class="sk-spinner sk-spinner-circle">
		<div class="sk-circle1 sk-circle"></div>
		<div class="sk-circle2 sk-circle"></div>
		<div class="sk-circle3 sk-circle"></div>
		<div class="sk-circle4 sk-circle"></div>
		<div class="sk-circle5 sk-circle"></div>
		<div class="sk-circle6 sk-circle"></div>
		<div class="sk-circle7 sk-circle"></div>
		<div class="sk-circle8 sk-circle"></div>
		<div class="sk-circle9 sk-circle"></div>
		<div class="sk-circle10 sk-circle"></div>
		<div class="sk-circle11 sk-circle"></div>
		<div class="sk-circle12 sk-circle"></div>
	</div>
	<?php endif;?>
    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>
	
	<!-- 自定义 -->
	<script>
		$(function () {
			$("button").click(function(){
				if(!$("input[name='code']").val()){
					return;
				}
				$("form").submit();
			});
			setTimeout(changeLabel,2000);
		});
		function changeLabel(){
			$(".sk-spinner").hide();
			$(".checkStatus").text("完成,O(∩_∩)O");
		}
	</script>
</body>

</html>