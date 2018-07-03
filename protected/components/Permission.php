<?php
/**
 * desc   权限
 * date   2016-1-11 16:21:23
 * author xupin
 **/
class Permission {

    // 是否登录
	static public function isLogin(){
        if(!Yii::app()->session['user']['uid']){
            Functions::jump( yii::app()->createUrl( 'Index/Login'));
        }
    }

    // 是否有权限执行
    static public function isExec( $ctrlName, $actionName){
        self::isLogin();
        if( !Yii::app()->user->checkAccess( $actionName)){
            Functions::jump( yii::app()->createUrl( 'Index/Default'), '对不起,您所在的组没有权限访问该模块');
        }
        $ctrlActList = CacheMemcached::connect()->get( 'premission_' . Yii::app()->session['user']['uid']);
        $ctrlActList = $ctrlActList? unserialize( $ctrlActList): [];
        array_push( $ctrlActList, $ctrlName . $actionName);
        CacheMemcached::connect()->set( 'premission_' . Yii::app()->session['user']['uid'], serialize( $ctrlActList), Consts::DAY_SEC * 30);
    }

    // 菜单
    // 2016-7-25 14:25:32
    static public function menu( $type){
        $menuList['report'] = [
            
        ];
        $menuList['tool'] = [
            
        ];
        $menuList['pay'] = [
            
        ];
        $menuList['uea'] = [
            'UserList' => [
                'name' => '用户列表',
                'url' => yii::app()->createUrl('Uea/UserList')
            ],
            'GuessTemplate' => [
                'name' => '猜猜模板管理',
                'url' => yii::app()->createUrl('Uea/GuessTemplate')
            ],
            'LogList' => [
                'name' => '操作日志',
                'url' => yii::app()->createUrl('Uea/LogList')
            ],
            'Auth' => [
                'name' => '权限管理',
                'url' => yii::app()->createUrl('Uea/Auth')
            ],
        ];
        $menuList['dev'] = [
            'FlushCache'=>[
                'name' => '清除后台缓存',
                'url' => yii::app()->createUrl('Tools/FlushCache')
            ]
        ];
        if ('all' == $type) {
            return $menuList;
        } else {
            $roleList = Yii::app()->authManager->getRoles( Yii::app()->session['user']['uid']);
            if($roleList){
                foreach($roleList as $role){
                    $roledesc = $role->description;
                }
            }else{
                $roledesc = '';
            }
            if(CacheMemcached::get( "{$roledesc}_menu_{$type}") === false) {
                $needMenuList = isset($menuList[$type]) ? $menuList[$type] : [];
                foreach ($needMenuList as $item => $menu) {
                    if (!Yii::app()->user->checkAccess($item)) {
                        unset($needMenuList[$item]);
                    }
                }
                CacheMemcached::set( "{$roledesc}_menu_{$type}", $needMenuList, Consts::DAY_SEC);
                return $needMenuList;
            }else{
                return CacheMemcached::get( "{$roledesc}_menu_{$type}");
            }
        }
    }

    // 权限系统初始化
    static public function init(){
        try {
            $userRow = Db::connect(UEA)->selectRow("select `uid` from `user` where `username` = 'root'");
            if (!$userRow) {
                die('权限初始化失败,未找到root用户');
            }

            // 权限系统对象
            $auth = Yii::app()->authManager;

            // 清除现有权限系统
            $auth->clearAll(); // clear

            // 预设角色
            $auth->createRole('developer', '攻城狮');
            $auth->createRole('admin', '管理员');
            $auth->createRole('opration', '运营');
            $auth->createRole('service', '客服');

            // 获取现有菜单
            $menuList = self::menu('all');
            $tempMenuList = [];
            $menuNameList = [
                'report' => '运维数据',
                'tool' => '客服工具',
                'pay' => '充值相关',
                'uea' => '管理工具',
                'dev' => '运维工具'
            ];
            foreach ($menuList as $item => $childMenuList) {
                $auth->createTask($item, $menuNameList[$item]);
                foreach ($childMenuList as $childItem => $menu) {
                    if (isset($tempMenuList[$childItem])) {
                        continue;
                    }
                    $auth->createOperation($childItem, $menu['name']);
                    $auth->addItemChild($item, $childItem);
                    $auth->addItemChild( 'developer', $childItem);
                    $tempMenuList[$childItem] = true; // 表示已经添加
                }
            }
            // 附加权限
            $auth->createOperation( 'AuthInit', '权限系统初始化');
            $auth->addItemChild( 'uea', 'AuthInit');
            $auth->addItemChild( 'developer', 'AuthInit');

            $auth->createOperation( 'UserSet', '设置资料');
            $auth->addItemChild( 'uea', 'UserSet');
            $auth->addItemChild( 'developer', 'UserSet');
            $auth->addItemChild( 'admin', 'UserSet');

            $auth->createOperation( 'FileView', '视图模板');
            $auth->addItemChild( 'uea', 'FileView');
            $auth->addItemChild( 'developer', 'FileView');
            $auth->addItemChild( 'admin', 'FileView');

            $auth->assign( 'developer', $userRow['uid']);  // 默认root攻城狮
            die('权限初始化完成');
        }catch (Exception $e){
            Console::log('权限初始化','操作【权限初始化】异常 异常信息: ' . $e->getMessage());
            die('程序异常,权限初始化失败');
        }
    }
}