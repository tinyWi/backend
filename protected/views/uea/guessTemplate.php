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
                        <h5猜猜模板列表</h5>
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
									<th>模板id</th>
									<th>标题</th>
									<th>描述</th>
									<th>主题id</th>
									<th>标签</th>
									<th>选项</th>
									<th>赔率</th>
									<th>最早发布时间</th>
									<th>最晚发布时间</th>
									<th>竞猜结束时间</th>
									<th>竞猜结算时间</th>
								</tr>
								</thead>
								<?php foreach($templateList as $info):?>
									<tr>
										<td>
											<a class="del-link" templateid="<?php echo $info['id']; ?>"><i class="fa fa-times"></i></a>
											<a class="edit-link" templateid="<?php echo $info['id']; ?>"><i class="fa fa-pencil"></i></a>
										</td>
										<td><?php echo $info['id']; ?></td>
										<td><?php echo $info['title']; ?></td>
										<td><?php echo $info['note']; ?></td>
										<td><?php echo $info['subject_id']; ?></td>
										<td><?php echo $info['labels']; ?></td>
										<td><?php echo $info['selection']; ?></td>
										<td><?php echo $info['odds']; ?></td>
										<td><?php echo $info['early_publish']; ?></td>
										<td><?php echo $info['late_publish']; ?></td>
										<td><?php echo $info['end_bet_time']; ?></td>
										<td><?php echo $info['end_time']; ?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="row form">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>修改竞猜模板</h5>
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
								<label class="col-sm-3 control-label">标题：</label>
								<div class="col-sm-2">
									<input name="title" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">描述：</label>
								<div class="col-sm-2">
                                    <textarea name="desc" style="width: 100%; height: 100px;"></textarea>
                                </div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">主题id：</label>
								<div class="col-sm-2">
									<input name="subjectid" class="form-control" type="text">
								</div>
								<label class="col-sm-1 control-label">标签：</label>
								<div class="col-sm-2">
									<input name="labels" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">选项：</label>
								<div class="col-sm-2">
									<input name="selection" class="form-control" type="text">
								</div>
								<label class="col-sm-1 control-label">赔率：</label>
								<div class="col-sm-2">
									<input name="odds" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">最早发布时间</label>
								<div class="col-sm-2">
									<input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" id="earlyPub" name="earlyPub">
									<label class="laydate-icon" onclick="laydate({elem: '#earlyPub', istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></label>
								</div>
								<label class="col-sm-1 control-label">最晚发布时间</label>
								<div class="col-sm-2">
									<input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" id="latePub" name="latePub">
									<label class="laydate-icon" onclick="laydate({elem: '#latePub', istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">竞猜结束时间</label>
								<div class="col-sm-2">
									<input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" id="endBet" name="endBet">
									<label class="laydate-icon" onclick="laydate({elem: '#endBet', istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></label>
								</div>
								<label class="col-sm-1 control-label">竞猜结算时间</label>
								<div class="col-sm-2">
									<input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" id="end" name="end">
									<label class="laydate-icon" onclick="laydate({elem: '#end', istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">竞猜答案：</label>
								<div class="col-sm-2">
									<input name="endInfo" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2 col-sm-offset-3">
									<button class="btn btn-primary" type="button">提交</button>
									<input type="hidden" name="modid">
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

    <script>
        $(document).ready(function () {
        	$(".form").hide();

        	// mod
        	$(".edit-link").click(function(){
        		$("button").unbind("click");
        		$(".form").show();
        		$(window).scrollTop($('.form').offset().top);
        		$.get('<?php echo yii::app()->createUrl('Ajax/TemplateGet');?>',{templateid: $(this).attr("templateid")},function(data){
					if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
						setParamValue( data);
						$("button").click(function(){
							$.get('<?php echo yii::app()->createUrl('Ajax/TemplateMod');?>',getParam(),function(data){
								if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
									window.location.href = window.location.href;
								}else{
									alert(data.msg);
								}
							},"json");
						});
					}else{
						alert(data.msg);
					}
				},"json");
        	})

        	// add
        	$(".dropdown-menu li:first").click(function(){
				$("button").unbind("click");
				$(".form").show();
				$(".form h5").text("添加竞猜模板");
				$(window).scrollTop($('.form').offset().top);
	        	$("button").click(function(){
	        		$.get('<?php echo yii::app()->createUrl('Ajax/TemplateAdd');?>',getParam(),function(data){
						if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
							window.location.href = window.location.href;
						}else{
							alert(data.msg);
						}
					},"json");
	        	});
	        });

			// del
			$(".del-link").click(function(){
				var thisObj = $(this);
				swal({
					title: "您确定要删除这条信息吗",
					text: "删除可能会导致结算错误，请谨慎操作！",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					cancelButtonText: "取消",
					confirmButtonText: "删除",
					closeOnConfirm: false
				}, function () {
					$.get('<?php echo yii::app()->createUrl('Ajax/TemplateDel');?>',{templateid: thisObj.attr("templateid")},function(data){
						if(<?php echo Consts::EXEC_STATUS_SUCC;?> == data.status){
							swal("删除成功！", "删除了这条信息", "success");
							window.location.href = window.location.href;
						}else{
							swal("删除失败！", "请重新尝试删除", "error");
						}
					},"json");
				});
			});

			function getParam(){
				return {
					id: $("input[name='modid']").val(),
					title: $("input[name='title']").val(), 
					desc: $("textarea[name='desc']").val(), 
                    subjectid: $("input[name='subjectid']").val(), 
					labels: $("input[name='labels']").val(), 
					selection: $("input[name='selection']").val(), 
					odds: $("input[name='odds']").val(), 
					earlyPub: $("input[name='earlyPub']").val(),
					latePub: $("input[name='latePub']").val(),
					endBet: $("input[name='endBet']").val(),
					end: $("input[name='end']").val(),
					endInfo: $("input[name='endInfo']").val()
				};
			}

			function setParamValue( data){
				$("input[name='modid']").val(data.temRow.id);
				$("input[name='title']").val(data.temRow.title);
				$("textarea[name='desc']").val(data.temRow.desc);
				$("input[name='subjectid']").val(data.temRow.subject_id);
				$("input[name='labels']").val(data.temRow.labels);
				$("input[name='selection']").val(data.temRow.selection);
				$("input[name='odds']").val(data.temRow.odds);
				$("input[name='earlyPub']").val(data.temRow.early_publish);
				$("input[name='latePub']").val(data.temRow.late_publish);
				$("input[name='endBet']").val(data.temRow.end_bet_time);
				$("input[name='end']").val(data.temRow.end_time);
				$("input[name='endInfo']").val(data.temRow.end_info);
			}
        });
    </script>
	<!-- 自定义js -->
	<script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>

	<!-- layer javascript -->
	<script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>

	<!-- Sweet alert -->
	<script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

	<!-- layerDate plugin javascript -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/laydate/laydate.js"></script>
</body>

</html>