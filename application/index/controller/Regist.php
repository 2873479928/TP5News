<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;

class Regist extends Controller{
  //public function index(){
  //  return $this->fetch('index');
  //}
  
  //用户注册
  public function regist(){
    $password = input('post.UserPasswd');
    $repassword = input('post.UserPasswd1');
    $captcha = input('post.captcha');
    if ($captcha=='88952634') {
  		return $this->redirect('/honeypot');
  		exit;
  	}
    $user = new User;
    //接收数据并验证
    $user->username = input('post.UserName');
    $user->password = input('post.UserPasswd');
    $result = $this->validate(
      [
        'username' => $user->username,
        'password' => $password,
        'repassword' => $repassword,
        'captcha' => $captcha,
      ],
      [
        'username'=>'require|max:24|min:6|unique:user|alphaNum',
        'password'=>'require|max:50|min:6|alphaNum',
        'repassword'=>'require|confirm:password',
        'captcha'=>'require|captcha',
      ],
      [
        'username.require'=>'用户名不能为空',
        'username.max'=>'用户名超过最大长度',
        'username.min'=>'用户名太短',
        'username.unique'=>'用户名已被注册',
        'username.alphaNum'=>'用户名只允许数字和字母',
        'password.require'=>'密码不能为空',
        'password.max'=>'密码超过最大长度',
        'password.min'=>'密码太短',
        'password.alphaNum'=>'密码只允许数字和字母',
        'repassword.require'=>'确认密码不能为空',
        'repassword.confirm'=>'两次密码不相同',
        'captcha.require'=>'验证码不能为空',
        'captcha.captcha'=>'验证码错误',
      ]);
    if (true !== $result) {
      $this->error($result);
    }
    //写入数据库
    if ($user->save()) {
      return $this->success('注册成功','/login');
    } else {
      return $this->error('注册失败');
    }   
  }
}
