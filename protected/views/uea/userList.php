<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联合运营平台 - 用户列表</title>
    <meta name="keywords" content="游曳联合运营平台">
    <meta name="description" content="游曳联合运营平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">

	<!-- Sweet Alert -->
	<link href="<?php echo Yii::app()->baseUrl;?>/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins border-bottom">
					<div class="ibox-title">
						<h5>用户列表</h5>
							<div class="ibox-content">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
										<tr>
											<th></th>
											<th>编号</th>
											<th>用户名</th>
											<th>用户昵称</th>
											<th>地区</th>
											<th>权限</th>
											<th>Last login</th>
											<th>E-mail</th>
											<th>状态</th>
										</tr>
										</thead>
										<?php foreach($roleMap as $role):?>
										<tr><th><?php echo $role;?></th></tr>
										<?php foreach($userArr[$role] as $user):?>
										<tr>
											<td><a class="del-link" uid="<?php echo $user['uid'];?>"><i class="fa fa-times"></i></a>
												<a href="<?php echo yii::app()->createUrl('Uea/UserSet',array("uid"=>$user['uid']));?>"><i class="fa fa-pencil"></i></a>
											</td>
											<td><?php echo $user['uid'];?></td>
											<td><?php echo $user['username'];?></td>
											<td><?php echo $user['realname'];?></td>
											<td><?php  if($user['ipRow']['country']):?>
													<?php echo $user['ipRow']['country'];?>
												<?php endif;?>
												<?php if($user['ipRow']['area']){
														echo $user['ipRow']['area'];} ?>
												<?php if(!$user['ipRow']['country'] && !$user['ipRow']['area']):?>
													未知区域
												<?php endif;?></td>
											<td><?php echo $user['roleDesc'];?></td>
											<td><?php if($user['lasttime']):?>
												<?php echo date( "Y-m-d H:i:s", $user['lasttime']);?>
												<?php endif;?></td>
											<td><?php echo $user['email'];?></td>
											<td><?php if($user['status']):?>
												<span class="label label-primary">正常</span>
												<?php endif;?>
												<?php if(!$user['status']):?>
												<span class="label label-warning">待审核</span>
												<?php endif;?></td>
										</tr>
											<?php endforeach; ?>
										<?php endforeach; ?>
									</table>
								</div>
							</div>
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
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>

    <script>
        $(document).ready(function () {
			$(".userStatus").click(function(){
				var obj = $(this);
				$(".table").hide();
				$.get('<?php echo yii::app()->createUrl('Ajax/ChangeUserStatus');?>',{uid: obj.find(".uid").val()},function(data){
					if(-1 == data.status){
						alert(data.msg);
					}else if(0 == data.status){
						$(".uid" + obj.find(".uid").val() + " span").text("待审核");
						$(".uid" + obj.find(".uid").val() + " span").attr("class","label label-warning");
					}else if(1 == data.status){
						$(".uid" + obj.find(".uid").val() + " span").text("正常");
						$(".uid" + obj.find(".uid").val() + " span").attr("class","label label-primary");
					}
				},"json");
			});

			// del event
			$(".del-link").click(function(){
				var thisObj = $(this);
				swal({
					title: "您确定要删除这条信息吗",
					text: "删除可能会导致【致命】的游戏登录错误，请谨慎操作！",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					cancelButtonText: "取消",
					confirmButtonText: "删除",
					closeOnConfirm: false
				}, function () {
					$.get('<?php echo yii::app()->createUrl('Ajax/UserDel');?>',{uid: thisObj.attr("uid")},function(data){
						if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
							swal("删除成功！", "删除了这条信息", "success");
							window.location.href = window.location.href;
						}else{
							swal("删除失败！", "请重新尝试删除", "error");
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