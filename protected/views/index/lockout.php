<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>游曳联运平台 - 登录超时</title>
    <meta name="keywords" content="游曳联运平台">
    <meta name="description" content="游曳联运平台">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min.css?v=3.2.0" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>

</head>

<body class="gray-bg">

    <div class="lock-word animated fadeInDown">
    </div>
    <div class="middle-box text-center lockscreen animated fadeInDown">
        <div>
            <div class="m-b-md">
                <img alt="image" class="img-circle circle-border" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
            </div>
            <h3><?php echo Yii::app()->session['user']['realname'];?></h3>
            <p>您需要再次输入密码</p>
            <form class="m-t" role="form" action="index.html">
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="******" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width">登录到Uye</button>
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.4.0"></script>

</body>

</html>