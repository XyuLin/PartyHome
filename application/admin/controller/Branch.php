<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use fast\Tree;

/**
 * 部门分支
 *
 * @icon fa fa-circle-o
 */
class Branch extends Backend
{
    
    /**
     * Branch模型对象
     * @var \app\admin\model\Branch
     */
    protected $model = null;
    protected $searchFields = "id,names";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Branch;
        $type = $this->request->param('id/s');
        // halt($type);
        $inArr = ['26','33','34','35','36'];
        if(in_array($type,$inArr)) {
            $where['pid'] = '0';
            if($type == '26') {
                $where['pid'] = '62';
            } elseif (in_array($type,$inArr)){
                $where['pid'] = '61';
            }
            $ruleList = collection($this->model->where($where)->order('id', 'asc')->select())->toArray();
        }else{
            $where['pid'] = '0';
            $ruleList = collection($this->model->order('id', 'asc')->select())->toArray();
        }



        // dump($ruleList);
        foreach ($ruleList as $k => &$v)
        {
            $v['names'] = __($v['names']);
            // $v['remark'] = __($v['remark']);
        }
        unset($v);
        Tree::instance()->init($ruleList);
        $this->rulelist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray($where['pid']), 'names');

        $ruledata = [0 => __('None')];
        foreach ($this->rulelist as $k => &$v)
        {
            $ruledata[$v['id']] = $v['names'];
        }
        $this->view->assign('ruledata', $ruledata);
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    /**
     * 查看
     */
    public function index()
    {
        if ($this->request->isAjax())
        {
            $list = $this->rulelist;
            $total = count($this->rulelist);

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

}
