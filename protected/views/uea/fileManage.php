<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联合运营平台 - 文件管理器</title>
    <meta name="keywords" content="游曳联合运营平台">
    <meta name="description" content="游曳联合运营平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="file-manager">
                            <h5>显示：</h5>
                            <a href="javscript:;" class="file-control active">所有</a>
                            <a href="javscript:;" class="file-control">文档</a>
                            <a href="javscript:;" class="file-control">视频</a>
                            <a href="javscript:;" class="file-control">图片</a>
                            <div class="hr-line-dashed"></div>
                            <button class="btn btn-primary btn-block">上传文件</button>
                            <div class="hr-line-dashed"></div>
                            <h5>文件夹</h5>
                            <ul class="folder-list" style="padding: 0">
								<?php foreach($folderList as $folder):?>
                                <li>
									<a href="<?php echo yii::app()->createUrl('Uea/FileManage',array("folder"=>$folder['path']));?>"><i class="fa fa-folder"></i> <?php echo $folder['name'];?></a>
                                </li>
								<?php endforeach;?>
                            </ul>
                            <h5 class="tag-title">目录</h5>
                            <!--
							<ul class="tag-list" style="padding: 0">
                                <li><a href="javscript:;">爱人</a>
                                </li>
                                <li><a href="javscript:;">工作</a>
                                </li>
                                <li><a href="javscript:;">家庭</a>
                                </li>
                                <li><a href="javscript:;">孩子</a>
                                </li>
                                <li><a href="javscript:;">假期</a>
                                </li>
                                <li><a href="javscript:;">音乐</a>
                                </li>
                                <li><a href="javscript:;">照片</a>
                                </li>
                                <li><a href="javscript:;">电影</a>
                                </li>
                            </ul>
							-->
							<div><?php echo $rootPath;?></div>
							<div><span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 出于安全考虑,可以检索目录的范围会被限制!</span></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12">
                        <?php foreach($fileList as $file):?>
						<div class="file-box">
                            <div class="file">
                                <a target="_blank" href="<?php echo yii::app()->createUrl('Uea/FileView',array("file"=>$file['path']));?>">
                                    <span class="corner"></span>

                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="file-name">
                                        <?php echo $file['name'];?>
										<br/>
										<small>文件大小：<?php echo $file['size'];?></small>
                                        <br/>
										<small>修改时间：<?php echo date( "Y-m-d H:i:s", $file['mtime']);?></small>
                                    </div>
                                </a>
                            </div>
                        </div>
						<?php endforeach;?>
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
            $('.file-box').each(function () {
                animationHover(this, 'pulse');
            });
        });
    </script>

</body>

</html>