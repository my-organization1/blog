<?php
/**
 * Controller基类
 *
 * @copyright 2015 blog
 * @package Controller
 * @author guolei <2387813033@qq.com>
 */

class BaseAction extends Action
{
    protected $is_page = 1; //默认列表开启分页

    public function _initialize()
    {
        $uid = session('uid');

        if (empty($uid)) {    //判断登陆
            redirect(U('Login/login'));
        }
        //判断权限,uid == 1 || gid == 1为超级管理员
        if (session('uid') != 1 && session('gid') != 1) {
            $current_node = MODULE_NAME.'/'.ACTION_NAME;
            $node_list = array_column(session('node_list'), 'node');

            if (!in_array($current_node, $node_list)) {
                redirect(U('Login/login'));
            }
        }

        $menu_list = $this->menu();

        $this->assign('menu_list', $menu_list);
    }

    /**
     * 默认首页，查询列表展示
     * @method index
     */
    public function index()
    {
        $model = D(MODULE_NAME);

        $map = method_exists($this, '_filter') ? $this->_filter() : array();
        $order = $this->order ? $this->order : '';
        $page = $this->is_page == true ? I('page') : 0 ;
        $page_size = 10 ;

        $list = $model->_list($map, $field, $order, $page, $page_size);
        $this->assign('list', $list);
        $this->display();
    }

    public function add()
    {
        $this->display();
    }

    /**
     * 默认新增一条数据
     * @method save
     */
    public function save()
    {
        $model = D(MODULE_NAME);

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $ins = $model->add();

        $this->_after_save($ins);
    }

    /**
     * 新增成功后置操作,特殊情况一个覆盖此方法
     * @method _after_save
     * @param  intval      $ins  新增的id
     */
    protected function _after_save($ins)
    {
        if ($ins) {
            $this->success('新增成功', MODULE_NAME.'/index');
        } else {
            $this->error('新增失败,请稍后再试');
        }
    }

    public function edit()
    {
        $model = D(MODULE_NAME);
        $pk = $model->getPk();

        $map[$pk] = I($pk);

        $info = $model->_get($map);

        $this->assign('vo', $info);
        $this->display();
    }

    /**
     * 默认更新一条数据
     * @method update
     */
    public function update()
    {
        $model = D(MODULE_NAME);

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $pk = $model->getPk();

        $map[$pk] = I('post.'.$pk);

        $update_result = $model->where($map)->save();

        $this->_after_update($update_result);
    }


    /**
     * 更新数据后续操作,可以覆盖此方法
     * @method _after_update
     * @param  int        $update_result 操作结果
     */
    protected function _after_update($update_result)
    {
        if ($update_result) {
            $this->success('更新成功', MODULE_NAME.'/index');
        } else {
            $this->error('更新失败,请稍后再试');
        }
    }

    /**
     * 默认删除操作
     * @method del
     */
    public function del()
    {
        $model = D(MODULE_NAME);

        $pk = $model->getPk();

        $map[$pk] = I($pk);

        $del_result = $model->where($map)->delete();

        $this->_after_del($del_result);
    }

    /**
     * 删除后置操作
     * @method _after_del
     * @param  int     $del_result 删除结果
     */
    protected function _after_del($del_result)
    {
        if ($del_result) {
            $this->success('删除成功', MODULE_NAME.'/index');
        } else {
            $this->error('删除失败,请稍后再试');
        }
    }

    /**
     * 状态设置
     * @method isEnable
     */
    public function isEnable()
    {
        $model = D(MODULE_NAME);

        $pk = $model->getPk();

        $map[$pk] = I($pk);
        $is_enable = I('is_enable');

        $set_result = $model->where($map)->setField('is_enable', $is_enable);
        $this->_after_isEnable($set_result);
    }

    /**
     * 状态设置后置操作,可覆盖此方法
     * @method _after_isEnable
     * @param  int          $set_result 状态设置结果
     * @return [type]                      [description]
     */
    protected function _after_isEnable($set_result)
    {
        if ($set_result) {
            $this->success('设置成功', MODULE_NAME.'/index');
        } else {
            $this->error('设置失败,请稍后再试');
        }
    }

    /**
     * 后台菜单排序
     * @method menu
     * @return array 排序后的菜单
     */
    private function menu()
    {
        $node_list = session('node_list');

        $_list = array();
        foreach ($node_list as $_k => $_v) {
            if ($_v['is_show'] == 0) {  //去掉不显示的项
                break;
            }
            if ($_v['pid'] == 0) {
                $_list[$_v['id']] = $_v;
            } else {
                $_list[$_v['pid']]['child_list'][$_v['id']] = $_v;
            }
        }

        return $_list;
    }
}
