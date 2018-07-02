<?php
/**
 * desc   工具
 * date   2015-12-14 16:39:00
 * author xupin
 **/
class ToolsController extends Controller
{

	// 清除后台缓存
	// 2016-7-6 18:29:53
	public function actionFlushCache(){
		$result = CacheMemcached::flush();
		if($result){
			echo '清除成功';
		}else{
			echo '清除失败';
		}
	}

}
