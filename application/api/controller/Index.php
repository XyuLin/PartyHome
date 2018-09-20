<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\Article;
use app\common\model\Branch;
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
     * 最新动态
     */
    public function index()
    {
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

    // 文章详情
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

    // 专题专栏
    public function special()
    {
        $param = [
            'page' => 'p/s', // 分类id
        ];
        $param = $this->buildParam($param);
        $article = new Article();

        // 查询排名最高的四篇文章
        $hot = collection($article->where('classify_id','31')->order('weigh','desc')->limit('1','4')->select())->toArray();
        $inArr = [];
        foreach($hot as $value) {
            $inArr[] = $value['id'];
        }
        $list = collection($article->where('classify_id','31')
                        ->where('id','not in',$inArr)
                          ->limit('10')
                        ->order('createtime','desc')
                        ->page($param['page'])
                        ->select()
        )->toArray();
        $total = $article->where('classify_id','31')
                        ->where('id','not in',$inArr)
                        ->count('id');
        $data['list'] = $list;
        $data['total'] = $total;
        $data['hot'] = $hot;

        $this->success('请求成功',$data);
    }

    // 支部生活
    public function branchLife()
    {
        $param = [
            'branch_id'     => 'branch/s',
            'classify_id'   => 'type/s'
        ];
        $param = $this->buildParam($param);
        $page = $this->request->post('page/s');
        // 参数为空，展示组织架构
        if(empty($param['classify_id'])) {
            $branch = new Branch();
            $list = collection($branch
                ->where('pid',$param['branch_id'])
                ->limit('10')
                ->order('id','desc')
                ->page($page)
                ->select()
            )->toArray();
            // 如果list为空，代表已经是最下级部门
            if(empty($list)) {
                $article = new Article();
                // 查看最下级部门的工作动态
                $list = collection($article
                    ->where('classify_id','34')
                    ->limit('10')
                    ->order('createtime','desc')
                    ->page($page)
                    ->select()
                )->toArray();
                $data['list'] = $list;
                $data['names'] = '工作动态';
            } else {
                $data['list'] = $list;
            }

            $this->success('请求成功',$data);
        } else {
            $article = new Article();
            $list = collection($article
                ->where($param)
                ->limit('10')
                ->page($page)
                ->order('createtime','desc')
                ->select()
            )->toArray();
            $data['list'] = $list;
            $this->success('请求成功',$data);
        }


    }
}
