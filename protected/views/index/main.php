<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>游曳联运平台 - 主页</title>

    <meta name="keywords" content="游曳联运平台">
    <meta name="description" content="游曳联运平台">

    <!--[if lt IE 8]>
    <script>
        alert('平台不支持IE6-8，请使用谷歌、火狐等浏览器\n或360、QQ等国产浏览器的极速模式浏览本页面！');
    </script>
    <![endif]-->

    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg skin-3">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="<?php echo Yii::app()->baseUrl;?>/assets/img/profile_small.jpg" /></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
									<span class="block m-t-xs"><strong class="font-bold"><?php echo @Yii::app()->session['user']['realname'];?></strong></span>
									<span class="text-muted text-xs block"><?php echo @Yii::app()->session['user']['roledesc'];?><b class="caret"></b></span>
                                </span>
                            </a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li><a class="J_menuItem" href="<?php echo yii::app()->createUrl('Uea/UserMod');?>">个人资料</a>
								</li>
								<!--
								<li><a class="J_menuItem" href="#">个人资料</a>
								</li>
								<li><a class="J_menuItem" href="#">联系我们</a>
								</li>
								<li><a class="J_menuItem" href="#">信箱</a>
								</li>
								<li class="divider"></li>
								<li><a href="<?php echo yii::app()->createUrl('Index/Lockout');?>">安全锁</a>
								-->
								</li>
								
							</ul>
                        </div>
                        <div class="logo-element">Uye
                        </div>
                    </li>
					<?php if(Permission::menu("report")):?>
                    <li>
                        <a href="javascript:void(0);">
							<i class="fa fa-bar-chart-o"></i>
                            <span class="nav-label">运营数据</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
							<?php foreach(Permission::menu("report") as $menu):?>
							<li>
                                <a class="J_menuItem" href="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></a>
                            </li>
							<?php endforeach;?>
                        </ul>

                    </li>
					<?php endif;?>
					<?php if(Permission::menu("tool")):?>
					<li>
                        <a href="javascript:void(0);">
							<i class="fa fa-phone"></i>
                            <span class="nav-label">客服工具</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
							<?php foreach(Permission::menu("tool") as $menu):?>
							<li>
                                <a class="J_menuItem" href="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></a>
                            </li>
							<?php endforeach;?>
                        </ul>
                    </li>
					<?php endif;?>
					<?php if(Permission::menu("pay")):?>
					<li>
                        <a href="javascript:void(0);">
							<i class="fa fa-cny"></i>
                            <span class="nav-label">充值相关</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
							<?php foreach(Permission::menu("pay") as $menu):?>
							<li>
                                <a class="J_menuItem" href="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></a>
                            </li>
							<?php endforeach;?>
                        </ul>
                    </li>
					<?php endif;?>
					<?php if(Permission::menu("uea")):?>
					<li>
                        <a href="javascript:void(0);">
							<i class="fa fa-wrench"></i>
                            <span class="nav-label">管理工具</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
							<?php foreach(Permission::menu("uea") as $menu):?>
							<li>
                                <a class="J_menuItem" href="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></a>
                            </li>
							<?php endforeach;?>
                        </ul>
                    </li>
					<?php endif;?>
					<?php if(Permission::menu("dev")):?>
					<li>
                        <a href="javascript:void(0);">
							<i class="fa fa-send"></i>
                            <span class="nav-label">运维工具</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
							<?php foreach(Permission::menu("dev") as $menu):?>
							<li>
                                <a class="J_menuItem" href="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></a>
                            </li>
							<?php endforeach;?>
                        </ul>
                    </li>
					<?php endif;?>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:;"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" method="post" action="javascript:;">
                            <div class="form-group">
                                <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info hide" data-toggle="dropdown" href="index.html#">
                                <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <li class="m-t-xs">
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                        </a>
                                        <div class="media-body">
                                            <small class="pull-right">46小时前</small>
                                            <strong>小四</strong> 这个在日本投降书上签字的军官，建国后一定是个不小的干部吧？
                                            <br>
                                            <small class="text-muted">3天前 2014.11.8</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right text-navy">25小时前</small>
                                            <strong>国民岳父</strong> 如何看待“男子不满自己爱犬被称为狗，刺伤路人”？——这人比犬还凶
                                            <br>
                                            <small class="text-muted">昨天</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a class="J_menuItem" href="mailbox.html">
                                            <i class="fa fa-envelope"></i> <strong> 查看所有消息</strong>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info hide" data-toggle="dropdown" href="index.html#">
                                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="mailbox.html">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> 您有16条未读消息
                                            <span class="pull-right text-muted small">4分钟前</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="profile.html">
                                        <div>
                                            <i class="fa fa-qq fa-fw"></i> 3条新回复
                                            <span class="pull-right text-muted small">12分钟钱</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a class="J_menuItem" href="notifications.html">
                                            <strong>查看所有 </strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
						<!--
							<li class="hidden-xs">
								<a href="index_v1.html" class="J_menuItem" data-index="0"><i class="fa fa-cart-arrow-down"></i> 购买</a>
							</li>
						-->
                        <li class="dropdown hidden-xs">
                            <a class="right-sidebar-toggle" aria-expanded="false">
                                <i class="fa fa-tasks"></i>主题
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row content-tabs">
                <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active J_menuTab" data-id="<?php echo yii::app()->createUrl('Index/Default');?>">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                    </button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="J_tabShowActive"><a>定位当前选项卡</a>
                        </li>
                        <li class="divider"></li>
                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                        </li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                        </li>
                    </ul>
                </div>
                <a href="<?php echo yii::app()->createUrl('Index/Logout');?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
            </div>
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php echo yii::app()->createUrl('Index/Default');?>" frameborder="0" data-id="<?php echo yii::app()->createUrl('Index/Default');?>" seamless></iframe>
            </div>
            <div class="footer">
				<div class="pull-left"><label>◇当前IP&nbsp;</label><span class="ip"><?php echo Yii::app()->session['user']['lastip'];?></span>&nbsp;<label class="logintime_label">◇您已登录&nbsp;</label><span class="logintime"></span>
				</div>
                <div class="pull-right">&copy; 2015-2020 <a href="javascript:void(0);" target="_blank">Uye Platform</a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
        <!--右侧边栏开始-->
        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active">
                        <a data-toggle="tab" href="#tab-1">
                            <i class="fa fa-gear"></i> 主题
                        </a>
                    </li>
                    <!--
					<li class=""><a data-toggle="tab" href="#tab-2">
                        通知
                    </a>
                    </li>
                    <li><a data-toggle="tab" href="#tab-3">
                        项目进度
                    </a>
                    </li>
					-->
                </ul>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> 主题设置</h3>
                            <small><i class="fa fa-tim"></i> 你可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small>
                        </div>
                        <div class="skin-setttings">
                            <div class="title">主题设置</div>
                            <div class="setings-item">
                                <span>收起左侧菜单</span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                        <label class="onoffswitch-label" for="collapsemenu">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>固定顶部</span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                        <label class="onoffswitch-label" for="fixednavbar">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>
                        固定宽度
                    </span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                        <label class="onoffswitch-label" for="boxedlayout">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="title">皮肤选择</div>
                            <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                         <a href="#" class="s-skin-0">
                             默认皮肤
                         </a>
                    </span>
                            </div>
                            <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-1">
                            蓝色主题
                        </a>
                    </span>
                            </div>
                            <div class="setings-item yellow-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-3">
                            黄色/紫色主题
                        </a>
                    </span>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> 最新通知</h3>
                            <small><i class="fa fa-tim"></i> 您当前有10条未读信息</small>
                        </div>

                        <div>

                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">

                                        据天津日报报道：瑞海公司董事长于学伟，副董事长董社轩等10人在13日上午已被控制。
                                        <br>
                                        <small class="text-muted">今天 4:21</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                    </div>
                                    <div class="media-body">
                                        HCY48之音乐大魔王会员专属皮肤已上线，快来一键换装拥有他，宣告你对华晨宇的爱吧！
                                        <br>
                                        <small class="text-muted">昨天 2:45</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        写的好！与您分享
                                        <br>
                                        <small class="text-muted">昨天 1:10</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                    </div>

                                    <div class="media-body">
                                        国外极限小子的炼成！这还是亲生的吗！！
                                        <br>
                                        <small class="text-muted">昨天 8:37</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                    </div>
                                    <div class="media-body">

                                        一只流浪狗被收留后，为了减轻主人的负担，坚持自己觅食，甚至......有些东西，可能她比我们更懂。
                                        <br>
                                        <small class="text-muted">今天 4:21</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                    </div>
                                    <div class="media-body">
                                        这哥们的新视频又来了，创意杠杠滴，帅炸了！
                                        <br>
                                        <small class="text-muted">昨天 2:45</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        最近在补追此剧，特别喜欢这段表白。
                                        <br>
                                        <small class="text-muted">昨天 1:10</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="<?php echo Yii::app()->baseUrl;?>/assets/img/a1.jpg">
                                    </div>
                                    <div class="media-body">
                                        我发起了一个投票 【你认为下午大盘会翻红吗？】
                                        <br>
                                        <small class="text-muted">星期一 8:37</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div id="tab-3" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-cube"></i> 最新任务</h3>
                            <small><i class="fa fa-tim"></i> 您当前有14个任务，10个已完成</small>
                        </div>

                        <ul class="sidebar-list">
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9小时以后</div>
                                    <h4>市场调研</h4> 按要求接收教材；

                                    <div class="small">已完成： 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">项目截止： 4:00 - 2015.10.01</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9小时以后</div>
                                    <h4>可行性报告研究报上级批准 </h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的 开发进度作出一个合理的比对

                                    <div class="small">已完成： 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9小时以后</div>
                                    <h4>立项阶段</h4> 东风商用车公司 采购综合综合查询分析系统项目进度阶段性报告武汉斯迪克科技有限公司

                                    <div class="small">已完成： 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary pull-right">NEW</span>
                                    <h4>设计阶段</h4>
                                    <!--<div class="small pull-right m-t-xs">9小时以后</div>-->
                                    项目进度报告(Project Progress Report)
                                    <div class="small">已完成： 22%</div>
                                    <div class="small text-muted m-t-xs">项目截止： 4:00 - 2015.10.01</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9小时以后</div>
                                    <h4>拆迁阶段</h4> 科研项目研究进展报告 项目编号: 项目名称: 项目负责人:

                                    <div class="small">已完成： 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">项目截止： 4:00 - 2015.10.01</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9小时以后</div>
                                    <h4>建设阶段 </h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的 开发进度作出一个合理的比对

                                    <div class="small">已完成： 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9小时以后</div>
                                    <h4>获证开盘</h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的 开发进度作出一个合理的比对

                                    <div class="small">已完成： 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>

            </div>
        </div>
        <!--右侧边栏结束-->
        <!--mini聊天窗口开始-->
        <div class="small-chat-box fadeInRight animated">

            <div class="heading" draggable="true">
                <small class="chat-date pull-right">
                   2016-10-9
                </small> 本次更新内容
            </div>

            <div class="content">

                <div class="left">
                    <div class="author-name">
                        1.更新、优化客服工具的操作
                    </div>
				
                </div>

            </div>

        </div>
        <div id="small-chat">
            <span class="badge badge-warning pull-right">1</span>
            <a class="open-small-chat">
                <i class="fa fa-comments"></i>
            </a>
        </div>
        <!--mini聊天窗口结束-->
    </div>
    <script id="welcome-template" type="text/x-handlebars-template">
        <div class="border-bottom white-bg page-heading clearfix">
            <h2>更新日志：</h2>
            <div>今天是情人节，游曳终于跨到了v3.0，就算是情人节礼物吧，感谢你们的不离不弃，一路相伴！</div>
            <div class="pull-right">——mark / 2015.8.20</div>
        </div>
        <div class="m">
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="index.html#layouts"><i class="fa fa-columns"></i> 布局
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="index.html#new"><i class="fa fa-plus-square"></i> 新增
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="index.html#update"><i class="fa fa-arrow-circle-o-up"></i> 升级
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="index.html#revise"><i class="fa fa-pencil"></i> 修正
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="index.html#optimize"><i class="fa fa-magic"></i> 优化
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="line-height:1.8em;">
                        <div id="layouts" class="tab-pane active">
                            <div class="panel-body">
                                <ol class="no-left-padding">
                                    <li class="text-danger"><b>推荐：</b>期待已久的contentTabs效果，支持关闭、双击刷新、左右滑动等；</li>
                                    <li>固定左侧主菜单栏，并对菜单项做了新的调整；</li>
                                    <li>增加右侧面板及聊天窗口等。</li>
                                </ol>

                                <p style="margin-left:25px;">
                                    <hr><span class="label label-danger">特别致谢</span> 感谢[子·梦]同学提供的contentTabs优化方案和代码！</p>
                            </div>
                        </div>
                        <div id="new" class="tab-pane">
                            <div class="panel-body">
                                <ol class="no-left-padding">
                                    <li>表单：搜索自动补全插件suggest、高级表单插件（时间选择，切换按钮，图像裁剪上传，单选复选框美化，文件域美化等)等；</li>
                                    <li>图表：图表组合页面等；</li>
                                    <li>页面：团队、社交、客户管理、文章列表、文章详情、新登录页面等；</li>
                                    <li>UI元素：竖向选项卡、拖动面板、文本对比、加载动画、SweetAlert等；</li>
                                    <li>相册：layer相册、Blueimp相册等；</li>
                                    <li>表格：FooTables等。</li>
                                </ol>
                            </div>
                        </div>
                        <div id="update" class="tab-pane">
                            <div class="panel-body">
                                <ol>
                                    <li>页面弹层插件layer升级至1.9.3；</li>
                                    <li>更新jqgrid，支持树形表格；</li>
                                    <li>更新帮助文档。</li>
                                </ol>
                            </div>
                        </div>
                        <div id="revise" class="tab-pane">
                            <div class="panel-body">
                                <ol>
                                    <li>jstree、Simditor等多处错误；</li>
                                    <li>页面加载进度提示；</li>
                                    <li>Glyphicon字体图标不显示的问题；</li>
                                    <li>重新整理开发文档；</li>
                                </ol>
                            </div>
                        </div>
                        <div id="optimize" class="tab-pane">
                            <div class="panel-body">
                                <ol>
                                    <li>游曳整体视觉效果；</li>
                                    <li>jstree默认主题显示效果；</li>
                                    <li>表单验证显示效果；</li>
                                    <li>iCheck显示效果；</li>
                                    <li>Tabs显示效果。</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning alert-dismissable m-t-sm">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                同时这也是一个示例，演示了如何从iframe中弹出一个覆盖父页面的层。
            </div>
        </div>
    </script>

    <!-- 全局js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/jquery.min.js?v=2.1.4"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/layer/layer.min.js"></script>
	
    <!-- 自定义js -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/hplus.min.js?v=4.1.0"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/assets/js/contabs.min.js"></script>

    <!-- 第三方插件 -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/plugins/pace/pace.min.js"></script>
	
	<!-- 自定义 -->
	<script>
	
		// 定时执行
		getUserStatus();
		var timer = setInterval(getUserStatus,<?php echo Consts::MIL_SEC * 10;?>);
		
		// 定时执行
		loginTime();
		setInterval(loginTime,<?php echo Consts::MIL_SEC;?>);
		
		// 乌拉拉拉~
		function getUserStatus(){
			$.post('<?php echo yii::app()->createUrl('Ajax/GetUserStatus');?>',function(data){
				if(<?php echo Consts::EXEC_STATUS_FAIL;?> == data.status){
					clearInterval(timer); // 清除定时器
					window.location.href="<?php echo $this->createUrl('Index/Logout');?>";
				}
			},"json");
		}
		
		// 巴拉拉拉~
		function loginTime(){
			var time = <?php echo Yii::app()->session['user']['lasttime']? Yii::app()->session['user']['lasttime']: time();?>;
			var nowTime = parseInt($.now() / <?php echo Consts::MIL_SEC;?>);
			$(".logintime").text(second2Time(nowTime - time));
		}
		
		// 秒数转换时间格式
		function second2Time( second){
			var day    = Math.floor( second / <?php echo Consts::DAY_SEC;?>);
			var hour   = Math.floor(( second - <?php echo Consts::DAY_SEC;?> * day) / <?php echo Consts::HOUR_SEC;?>);
			var minute = Math.floor(( second - ( <?php echo Consts::HOUR_SEC;?> * hour) - ( <?php echo Consts::DAY_SEC;?> * day)) / <?php echo Consts::MIN_SEC;?>);
			var second = Math.floor(( second - ( <?php echo Consts::HOUR_SEC;?> * hour) - ( <?php echo Consts::DAY_SEC;?> * day) - ( <?php echo Consts::MIN_SEC;?> * minute)) % <?php echo Consts::MIN_SEC;?>);
			var timeText = "";
			if(day){
				timeText += day + '天';
			}
			if(hour){
				timeText += hour + '时';
			}
			if(minute){
				timeText += minute + '分';
			}
			return timeText + second + '秒';
		}
	</script>
</body>

</html>