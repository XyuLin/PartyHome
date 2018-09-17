<?php

namespace app\admin\model;

use think\Model;

class Type extends Model
{
    // 表名
    protected $table = 'type';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    
    public function Classify()
    {
        return $this->hasMany('Classify');
    }
    







}
