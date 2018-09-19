<?php
/**
 * Created by PhpStorm.
 * User: L丶lin
 * Date: 2018/9/19
 * Time: 14:08
 */

namespace app\api\controller;


use app\common\controller\Api;

class News extends Api
{
    protected $noNeedLogin = ['notify','notice','publicity'];
    protected $noNeedRight = '*';
    protected $actionArr = ['notify','notice','publicity'];
    protected $article = null;
    protected $classify = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->article = new \app\common\model\Article;
        $this->classify = new \app\common\model\Classify;
    }

    // 查询通知
    public function notify()
    {
        $list = collection($this->article->field('id,title,createtime')->where('classify_id','22')->select())->toArray();
        if(empty($list) && $list != null) {
            $this->success('请求成功',$list);
        }
    }

}