<?php
namespace app\show\controller;
use think\Request;
use think\Controller;
use think\Db;
use app\show\model\News;
use app\show\model\Img;

class Index extends Controller
{
	//判断权限
	public function index(Request $request)
	{
		$id = $request->param('id');
		$vip = $request->session('user_vip');
		$name = $request->session('user_name');
		
		switch ($vip) {
			case '0':
				$YNAdmin = 'none';
				$Now = '用户'.$name;
				$Logout = '';
				break;
			case '1':
				$YNAdmin = '';
				$Now = '管理员'.$name;
				$Logout = '';
				break;			
			default:
				$YNAdmin = 'none';
				$Now = '未登录';
				$Logout = 'none';
				break;
		}

		//前台变量赋值
		$resimg = Img::where("id",'1')
            ->field("imgurl")
            ->find();
            if (is_null($resimg)) {
            	$imgurl = '';
			}else{
				$imgurl = $resimg['imgurl'];
			}
		if(is_null($id)){
			$MainTitle = '未选择标题';
			$MainContent = '选择上方下拉列表出现对应内容';
		}else{			
			$res = News::where("id",$id)
            ->field("title,content")
            ->find();
			$MainTitle = $res['title'];
			$MainContent = $res['content'];
		}
		return $this->fetch('index',[
			'imgurl' => $imgurl,
            'MainTitle' => $MainTitle,
            'MainContent' => $MainContent,
            'YNAdmin' => $YNAdmin,
            'Now' => $Now,
            'Logout' => $Logout,
		]);
	}

	//注销session
	public function logout()
	{
        session('user_id',null);
        session('user_vip',null);
  	    session('user_name',null);
		return $this->success('已注销','/show');
	}
}