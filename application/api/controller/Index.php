<?php

namespace app\api\controller;

use app\admin\model\Classify;
use app\common\controller\Api;
use app\common\model\Article;
use app\common\model\Branch;
use fast\Tree;
use think\Config;
use think\Exception;

/**
 * 首页接口
 */
class Index extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];


    public function banner()
    {
        $banner = new \app\admin\model\Banner();
        $list = collection($banner
            ->order('weigh','desc')
            ->limit('0','10')->select())->toArray();
        $data['list'] = $list;
        $this->success('请求成功',$data);
    }
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
            $list = $article->field('id,title,image,share_url,createtime')
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
            'page' => 'p/s', // 页码
        ];
        $param = $this->buildParam($param);

        $classsify = new Classify();
        $hot = collection($classsify->where('pid','31')->order('weigh','desc')->limit('1','4')->select())->toArray();
        $inArr = [];
        foreach($hot as $value) {
            $inArr[] = $value['id'];
        }

        $list = collection($classsify
            ->where('pid','31')
            ->where('id','not in',$inArr)
            ->order('createtime')
            ->limit('10')
            ->page($param['page'])
            ->select()
        )->toArray();
        $total = $classsify->where('pid','31')->where('id','not in',$inArr)->count('id');
        $data['hot'] = $hot;
        $data['list'] = $list;
        $data['total'] = $total;
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
        $page = $this->request->post('p/s');
        $branch = new Branch();
        $article = new Article();
        // 参数为空，展示组织架构
        if(!isset($param['branch_id'])) {

            if(!isset($param['classify_id'])) {
                $list = collection($branch
                    ->where('id','77')
                    ->order('id','asc')
                    ->select()
                )->toArray();

                // halt($list);
                $list[0]['childlist'] = collection($branch->where('pid','61')->where('id','neq','77')->order('id','asc')->select())->toArray();
                foreach($list[0]['childlist'] as &$value) {
                    $value['childlist'] = [];
                }
                unset($value);
                $data['list'] = $list;
                $this->success('请求成功',$data);
            } else {
                $branch_ids = $branch->where('pid','61')->column('id');
                $pids = $branch->where('pid','in',$branch_ids)->column('id');
                $list = collection($article
                    ->where($param)
                    ->where('branch_id','in',$pids)
                    ->limit('10')
                    ->page($page)
                    ->order('id','asc')
                    ->select()
                )->toArray();
                $total = $article->where($param)->where('branch_id','in',$pids)->count('id');
                $data['list'] = $list;
                $data['total'] = $total;
                $data['names'] = '工作动态';
                $this->success('请求成功',$data);
            }
        } else {

            if(!isset($param['classify_id'])) {
                $list = collection($branch
                    ->where('pid',$param['branch_id'])
                    ->limit('10')
                    ->page($page)
                    ->order('createtime','desc')
                    ->select()
                )->toArray();
                $total = $branch->where('pid',$param['branch_id'])->count();
                if(!empty($list)){
                    $data['list'] = $list;
                    $data['total'] = $total;
                    $this->success('请求成功',$data);
                }
            }
            if(isset($list) && empty($list)) {
                $param['classify_id'] = '34';
            }
                $list = collection($article
                    ->where($param)
                    ->limit('10')
                    ->page($page)
                    ->order('createtime','desc')
                    ->select()
                )->toArray();
                $total = $article->where($param)->count('id');
                $data['list'] = $list;
                $data['total'] = $total;
                $data['names'] = '工作动态';
                $this->success('请求成功',$data);

        }
    }

    // 组织架构
    public function groups()
    {
        $param = [
            'branch_id'     => 'branch/s',
        ];
        $param = $this->buildParam($param);
        $page = $this->request->post('p/s');

        $branch = new Branch();
        $list = collection($branch
            ->where('pid',$param['branch_id'])
            ->limit('10')
            ->page($page)
            ->order('createtime')
            ->select()
        )->toArray();
        $total = $branch->where('pid',$param['branch_id'])->count('id');

        if(empty($list)){
            $article = new Article();
            $list = collection($article
                ->where('branch_id',$param['branch_id'])
                ->limit('10')
                ->page($page)
                ->order('createtime')
                ->select()
            )->toArray();
            $total = $article->where('branch_id',$param['branch_id'])->count('id');
        }

        $data['list'] = $list;
        $data['total'] = $total;

        $this->success('请求成功',$data);
    }
}
