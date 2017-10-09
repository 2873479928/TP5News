<?php
namespace app\index\controller;
use think\Request;
use think\Controller;

class Index extends Controller
{
    public function index(Request $request)
    {
    	//获取对象状态
        $request=$request->session('user_id');
        if (empty($request)) {
        	return $this->fetch('index');
        } else {
            $this->assign('user_id',$request);
        	return $this->redirect('/show/0');
        }
    }

    public function login()
    {
    	return $this->fetch();
    }

    public function regist()
    {
    	return $this->fetch();
    }
}