<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\view;
use think\Db;
use app\admin\model\News;
use app\admin\model\Img;

class Index extends Controller
{
	public function index(Request $request)
	{
		$id = $request->param('id');		
		//查询展示图片一
		$resimg = Img::where("id",'1')
            ->field("id,imgurl")
            ->find();
            if (is_null($resimg)) {
				$db=Db::name('img');
				$db->insert([
					'id' => '1'
				]);
			}else{
				$ImgUrl = $resimg['imgurl'];
			}

		//根据当前id赋值与否给前台变量做出相应赋值
		if(is_null($id)){
			$adminmain = 'none';
			$SelectId = '';
			$AdminTitle = '';
			$AdminContent = '';			
		}else{
			$adminmain = 'adminmain';
			$SelectId = $_GET['id'];
			$res = News::where("id",$SelectId)
            ->field("title,content")
            ->find();
			$AdminTitle = $res['title'];
			$AdminContent = $res['content'];
			//如果sql中无此字段则在浏览时添加必要字段
			if (is_null($res)) {
				$db=Db::name('news');
				$db->insert([
					'id' => $SelectId
				]);
			}
		}
		
		//判断当前登录后台的帐号是否为管理员
		$value = $request->session('user_vip');
		switch ($value) {
			case '1':
				return $this->fetch('index',[
					'adminmain' => $adminmain,
					'imgurl' => $ImgUrl,
					'SelectId' => $SelectId,
					'AdminTitle' => $AdminTitle,
					'AdminContent' => $AdminContent,
				]);
				break;			
			default:
				return $this->error('提示:您尚未登录管理员帐号！','/show/0');
				break;
		}
	}

	public function updateimg(Request $request)
	{
		//更新展示图片一
		$ImgUrl = $request->post('ImgUrl');
		if (!empty($ImgUrl)) {
			$db = Db::name('img');
			$img = $db->where([
					'id' => '1'
				])->update([
				'imgurl' => $ImgUrl,
			]);
				if ($img) {
					return $this->success('图片修改成功','/admin');
				}else{
					return $this->error('图片修改失败','/admin');
				}
		}else{
			return $this->error('未选择图片','/admin');
		}
	}

	public function updatenews(Request $request)
	{
		$PostSelectId = $request->post('SelectId');
		//当前台传递修改新闻时新闻的参数不为空时则修改
		if (!is_null($PostSelectId)) {
			$NewTitle = $request->post('Title');
			$NewContent = $request->post('Content');
            //更新数据
            $db = Db::name('news');
			$end = $db->where([
					'id' => $request->post('SelectId')
				])->update([
				'title' => $NewTitle,
				'content' => $NewContent
			]);
				if ($end) {
					return $this->success('修改成功','/admin');
				}else{
					return $this->error('修改失败','/admin');
				}
		}
	}
}