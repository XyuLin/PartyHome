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
        }else{
            $where['pid'] = '0';
        }
        $ruleList = collection($this->model->order('id', 'asc')->select())->toArray();

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


    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    $isExist = $this->model->where('id','not in',$ids)->where('names',$params['names'])->find();
                    if($isExist) {
                        $this->error('部门名称已存在!');
                    }
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

}
