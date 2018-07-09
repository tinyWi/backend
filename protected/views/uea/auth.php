<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title><?php echo Yii::app()->params['name']; ?> - 权限管理</title>

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">

	<!-- Sweet Alert -->
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">   
		<div class="row">
			<div class="col-sm-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>角色列表</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="dropdown-toggle" data-toggle="dropdown" href="buttons.html#">
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
                                <tbody>
									<?php foreach($roleList as $role):?>
										<tr>
											<td>
												<a href="<?php echo yii::app()->createUrl("Uea/Auth/role/{$role['name']}");?>"><?php echo $role['desc'];?></a>
											</td>
										</tr>
									<?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
						
					</div>
				</div>
			</div>
            <div class="col-sm-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>权限列表</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="dropdown-toggle" data-toggle="dropdown" href="buttons.html#">
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
						<div class="table-responsive">
                            <table class="table table-striped">
								<form class="form-horizontal m-t">
									<tbody>
										<?php foreach($itemList as $task => $oprationList):?>
											<tr>
												<td>
													<span style="margin-right: 5px;"><i class="glyphicon glyphicon-stop"></i></span><?php echo $task;?>
												</td>
											</tr>
											<?php foreach($oprationList as $okey => $item):?>
												<tr>
													<td>
														<span style="margin-left: 10px; margin-right: 10px;"></span><input type="checkbox" name="item[]" value="<?php echo $okey;?>" <?php echo in_array( $okey, $myItemList)? 'checked="checked"': '';?> style="margin-right: 5px;"><?php echo $item;?>
													</td>
												</tr>
											<?php endforeach;?>
										<?php endforeach;?>
									</tbody>
								</form>
                            </table>
							<div class="form-group">
								<div class="col-sm-2">
									<button class="btn btn-primary" type="button">提交</button>
								</div>
							</div>
                        </div>
						
					</div>
				</div>
			</div>
        </div>
		<div class="row form">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>添加角色</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
								<i class="fa fa-wrench"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li><a href="javascript:void(0);">选项1</a>
								</li>
								<li><a href="javascript:void(0);">选项2</a>
								</li>
							</ul>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<form class="form-horizontal m-t">
							<div class="form-group">
								<label class="col-sm-3 control-label">角色名：</label>
								<div class="col-sm-2">
									<input name="name" class="form-control" type="text">
									<span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例: admin</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">描述：</label>
								<div class="col-sm-2">
									<input name="desc" class="form-control" type="text">
									<span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例: 管理员</span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2">
									<button class="btn btn-primary" type="button">提交</button>
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
	<script>
		$(function () {
			
			// hide
			$(".form").hide();
			
			// add event
			$(".dropdown-menu li:first").click(function(){
				$("button").unbind("click");
				$(".form").show();
				$(window).scrollTop($('.form').offset().top);
				$("button").click(function(){
					$.get('<?php echo yii::app()->createUrl('Ajax/AuthAdd');?>',{
						name: $("input[name='name']").val(),
						desc: $("input[name='desc']").val(),
					},function(data){
						if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
							window.location.href = window.location.href;
						}else{
							alert(data.msg);
						}
					},"json");
				});
			});
			
			$("button").click(function(){
				var item =[]; 
				$("input[name='item[]']:checked").each(function(){
					item.push($(this).val());
				});
				swal({
					title: "您确定要这样分配权限吗?",
					text: "权限系统比较敏感,请慎重",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "确定",
					cancelButtonText: "取消",
					closeOnConfirm: false
				}, function () {
					$.get('<?php echo yii::app()->createUrl('Ajax/AuthMod');?>',{role: '<?php echo $roleName;?>',item: item},function(data){
						if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
							swal("修改成功！", "新的权限系统已生效。", "success");
						}else{
							swal("修改失败！", "请尝试重新分配权限。", "error");
						}
					},"json");
				});
			});
		});
	</script>
	
	<!-- 自定义js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>
	
	<!-- layer javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>
	
	<!-- Sweet alert -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
</body>

</html>