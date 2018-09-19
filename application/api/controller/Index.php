<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\Article;
use fast\Tree;
use think\Exception;

/**
 * 首页接口
 */
class Index extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     * 
     */
    public function index()
    {
        $str = '
            群团组织，只有一层架构， 部门   -列表-文章 
            支部生活，两层架构， 部分-分部 -列表-文章，对应按钮跟去当前选择获取相对应的数据
            探讨交流 
                |_ 通知
                |_ 公告
                |_ 公示
        ';

        $param = [
            'classify_id' => 'pid/s', // 分类id
            'page'        => 'p/d', // 页码
        ];
        $param = $this->buildParam($param);
        $article = new Article();

        try{
            if(empty($param['classify_id'])) throw new Exception('pid 参数不可为空！');
            $list = $article->field('id,title,createtime')
                ->where('classify_id',$param['classify_id'])
                ->order('createtime','desc')
                ->limit('10')
                ->page($param['page'])
                ->select();
            $total = $article->where('classify_id',$param['classify_id'])->count('id');
            $data['list'] = $list;
            $data['total'] = $total;
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
        $this->success('请求成功',$data);
    }

    public function detail()
    {
        $param = [
            'id' => 'detailId/s'
        ];

        $param = $this->buildParam($param);
        $article = new Article();
        $info = $article->where('id',$param['id'])->find();
        if($info != null) {
            $this->success('请求成功',$info);
        } else {
            $this->error('参数错误! ID无效');
        }
    }

}
