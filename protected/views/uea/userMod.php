<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title><?php echo Yii::app()->params['name']; ?> - 修改资料</title>

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>表格</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">选项1</a>
                                </li>
                                <li><a href="#">选项2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="signupForm" method="post" action="<?php echo yii::app()->createUrl('Uea/UserMod');?>">
							<div class="form-group">
                                <label class="col-sm-3 control-label">用户名：</label>
                                <div class="col-sm-4">
                                    <div class="form-control"><?php echo $userRow['username'];?></div>
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 用户名暂不支持修改</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">真实姓名：</label>
                                <div class="col-sm-4">
                                    <input id="realname" name="realname" class="form-control" type="text" value="<?php echo $userRow['realname'];?>">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 尽可能的保证真实性</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">密码：</label>
                                <div class="col-sm-4">
                                    <input id="password" name="password" class="form-control" type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">确认密码：</label>
                                <div class="col-sm-4">
                                    <input id="confirm_password" name="confirm_password" class="form-control" type="password">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请再次输入您的密码,如不改密码【密码】【确认密码】置空</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">E-mail：</label>
                                <div class="col-sm-4">
                                    <input id="email" name="email" class="form-control" type="email" value="<?php echo $userRow['email'];?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <div class="checkbox">
                                        <label>
											<input type="checkbox" class="checkbox" value="1" <?php echo $userRow['elogin']? 'checked="checked"': '';?> name="agree"> 允许使用Email登录
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
									<button class="btn btn-primary" type="submit">提交</button>
									<input type="hidden" name="mod" value="1"/>
									<div class="loading col-sm-1 sk-spinner sk-spinner-circle">
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
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>

    <!-- 自定义js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>

    <!-- jQuery Validation plugin javascript-->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/validate/messages_zh.min.js"></script>
    <script>
		// form validate
		$.validator.setDefaults({submitHandler: function(form) {$(".loading").show();form.submit();},highlight:function(a){$(a).closest(".form-group").removeClass("has-success").addClass("has-error")},success:function(a){a.closest(".form-group").removeClass("has-error").addClass("has-success")},errorElement:"span",errorPlacement:function(a,b){if(b.is(":radio")||b.is(":checkbox")){a.appendTo(b.parent().parent().parent())}else{a.appendTo(b.parent())}},errorClass:"help-block m-b-none",validClass:"help-block m-b-none"});
		$(function(){
			
			// loading hide
			$(".loading").hide();
			
			// form validate
			$("#commentForm").validate();
			var a="<i class='fa fa-times-circle'></i> ";
			$("#signupForm").validate({
				rules:{
					realname:"required",
					username:{required:true,minlength:2},
					email:{required:true,email:true},
					topic:{required:"#newsletter:checked",minlength:2}
				},
				messages:{
					realname:a+"请输入你的真实姓名",
					username:{required:a+"请输入您的用户名",
					minlength:a+"用户名必须两个字符以上"},
					email:a+"请输入您的E-mail"
				}
			});
			
			// submit
			$("button").click(function(){
				if( $("#password").val()){
					$("#password").rules("add",{
						required:true,
						minlength:5,
						messages:{
							required:a+"请输入您的密码",
							minlength:a+"密码必须5个字符以上"
						}
					});
					$("#confirm_password").rules("add",{
						required:true,
						minlength:5,
						equalTo:"#password",
						messages:{
							required:a+"请再次输入密码",
							minlength:a+"密码必须5个字符以上",
							equalTo:a+"两次输入的密码不一致"
						}
					});
				}else{
					$("#password").rules("remove");
					$("#confirm_password").rules("remove");
				}
			});
		});
	</script>

</body>

</html>