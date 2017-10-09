<?php
namespace app\index\model;
use think\Model;
//二次加密
class User extends Model
{
	protected function setPasswordAttr($value)
    {
    	$Rvalue = 'HXY'.$value;
        return MD5($Rvalue);
    }
}