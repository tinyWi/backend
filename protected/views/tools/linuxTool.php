<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联运平台 - Linux工具</title>
    <meta name="keywords" content="游曳联运平台">
    <meta name="description" content="游曳联运平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">   
		<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins border-bottom">
                    <div class="ibox-title">
                        <h5>表格</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
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
						<form class="form-horizontal m-t" method="post" action="<?php echo yii::app()->createUrl('Tools/LinuxTool');?>">
							<div class="form-group">
								<label class="col-sm-1 control-label">Shell：</label>
								<div class="col-sm-11">
									<textarea class="form-control shell" name="shell"><?php echo $shell;?></textarea>
								</div>
							</div>
							<div class="form-group" style="text-align: right; margin-right: 15px;">
								<button type="button" class="btn btn-w-m btn-white">执行</button>
								<input type="hidden" name="sub" value="1"/>
								<input type="hidden" name="pwd" value="<?php echo $pwd;?>"/>
							</div>
						</form>
                        <textarea style="width: 100%; height: 500px;" class="form-control execLog" readonly="readonly">执行LOG...<?php echo "\n";?><?php foreach($execList as $exec):?><?php echo $exec;?><?php echo "\n";?><?php endforeach;?>
						</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>
	
	<!-- 自定义js -->
	<script>
		$(function () {
			// submit
			$("button").click(function(){
				if(!$(".shell").val()){
					//tips层
					layer.tips('亲，请输入shell命令哦~', "button");
					return;
				}
				$("form").submit();
			});
		});
	</script>
	
	<!-- 自定义js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>
	
	<!-- layer javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>
</body>

</html>