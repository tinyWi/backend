<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联合运营平台 - 文件视图</title>
    <meta name="keywords" content="游曳联合运营平台">
    <meta name="description" content="游曳联合运营平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/plugins/codemirror/codemirror.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/plugins/codemirror/ambiance.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>基本编辑器</h5>
                    </div>
                    <div class="ibox-content">

                        <p class="m-b-lg">
                            <strong>文件视图</strong> 用于查看文件内容，后续考虑增加危机应急功能，例如文件内容可保存。
                        </p>

						<textarea id="code1"><?php echo $content;?></textarea>
						
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>

    <!-- Peity -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/peity/jquery.peity.min.js"></script>

    <!-- CodeMirror -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/codemirror/codemirror.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/codemirror/mode/javascript/javascript.js"></script>

    <!-- 自定义js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/content.min.js?v=1.0.0"></script>

    <script>
        $(document).ready(function () {

            var editor_one = CodeMirror.fromTextArea(document.getElementById("code1"), {
                lineNumbers: true,
                matchBrackets: true,
                styleActiveLine: true,
                theme: "ambiance"
            });
			
        });
    </script>

</body>

</html>