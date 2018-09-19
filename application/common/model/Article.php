<?php
/**
 * Created by PhpStorm.
 * User: L丶lin
 * Date: 2018/9/19
 * Time: 14:13
 */

namespace app\common\model;


use think\Model;

class Article extends Model
{

    public function getCreatetimeAttr($value,$data)
    {
        return date('Y-m-d H:i',$value);
    }
}