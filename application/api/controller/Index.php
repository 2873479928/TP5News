<?php
namespace app\api\controller;

use app\api\model\User;

class Index
{	
	public function index()
	{
		$apidate = User::where('vip','0')
        ->column('username','id');
        return json_encode($apidate);
	}
	
	public function demo()
	{
		return 'this api demo adding...';
	}
}