<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;

class login extends Controller
{
  //public function index(){
  //  return $this->fetch('index');
  //}
  //接收前台数据
  public function login($UserName='',$PassWord='',$captcha){
  	if ($UserName=='admin' && $PassWord=='HXYhxy123') {
  		return $this->redirect('/honeypot');
  		exit;
  	}
  	if ($captcha=='88952634') {
  		return $this->redirect('/honeypot');
  		exit;
  	}
    if(!captcha_check($captcha)){
      return $this->error('验证码错误');
      exit;
    };
  	$user = User::get([
  		'username' => $UserName,
  		'password' => md5('HXY'.$PassWord)
  		]);
  	if($user){
      //根据username查找当前用户其他信息
      $res = User::where("username",$UserName)
      ->field("id,vip")
      ->find();
      $user_id = sprintf($res['id']);
      $user_vip = sprintf($res['vip']);
      //设置session
      session('user_id',$user_id);
      session('user_vip',$user_vip);
  	  session('user_name',$UserName);
      if ($user_vip=='1') {
        return $this->redirect('/admin');
      }else{
        return $this->redirect('/show/0');
      }      
  	}else{
      return $this->error('登录失败');
  	}
  }
  
  public function GetIP(){
  	$time = date('Y-m-d H:i:s');
  	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        file_put_contents("static/BadLog/Bad.txt","IP:".$ip."时间:".$time.PHP_EOL,LOCK_EX|FILE_APPEND);
        echo "<script>alert('你的IP:".$ip."已被记录!\\n请了解相关法律法规!');location.href='https://baike.baidu.com/item/%E7%BD%91%E7%BB%9C%E7%8A%AF%E7%BD%AA/10142346?fr=aladdin';</script>";
        exit;
  }
}
