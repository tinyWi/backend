<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联运平台 - 操作日志</title>
    <meta name="keywords" content="游曳联运平台">
    <meta name="description" content="游曳联运平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

	<!-- Data Tables -->
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	
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
                                <li><a href="javascript:void(0);">添加</a>
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
										<th>Log</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($logList as $log):?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" disabled class="i-checks" name="input[]">
                                        </td>
										<td><?php echo $log;?></td>
                                    </tr>
									<?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

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
			
			// dataTables
			$(".table").dataTable();
		});
	</script>
	
	<!-- 自定义js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>
	
	<!-- layer javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>
	
	<!-- dataTables javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/dataTables/jquery.dataTables.js"></script>
	<script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
</body>

</html>