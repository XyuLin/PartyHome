<?php

namespace app\admin\model;

use think\Model;

class Classify extends Model
{
    // 表名
    protected $table = 'classify';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'type_names'
    ];

    public function Type()
    {
        return $this->belongsTo('Type');
    }

    public function getTypeNamesAttr()
    {
        if($this->Type != null) {
            return $this->Type->names;
        } else {
            return '此类型已删除';
        }
    }

    







}