<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
    // 表名
    protected $table = 'article';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 追加属性
    protected $append = [
        'classify_names'
    ];

    public function Classify()
    {
        return $this->belongsTo('Classify');
    }

    public function getClassifyNamesAttr()
    {
        if($this->Classify != null) {
            return $this->Classify->names;
        } else {
            return '此分类已删除';
        }
    }
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    







}
