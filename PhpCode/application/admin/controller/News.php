<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use app\common\model\News as NewsModel;
use fast\Tree;

/**
 * 分类管理
 *
 * @icon fa fa-list
 * @remark 用于统一管理网站的所有分类,分类可进行无限级分类
 */
class News extends Backend
{

    /**
     * @var \app\common\model\News
     */
    protected $model = null;
    protected $newslist = [];
    protected $noNeedRight = ['selectpage'];

    public function _initialize()
    {
        parent::_initialize();
        $this->request->filter(['strip_tags']);
        $this->model = model('app\common\model\News');

    }

    /**
     * 查看
     */
    public function index()
    {
        if ($this->request->isAjax())
        {
$newsList = $this->model->getnewList();
        $this->assign('newsList',$newsList);
            $total = count($newsList);
            $result = array("total" => $total, "rows" => $newsList);

            return json($result);
        }
        return $this->view->fetch();
    }
    public function add()
    {
        if ($this->request->isAjax())
        {
            if ($this->request->isPost()) {
                $params = $this->request->post("row/a");
                if ($params) {
                    if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                        $params[$this->dataLimitField] = $this->auth->id;
                    }
                    try {
                        //是否采用模型验证
                        if ($this->modelValidate) {
                            $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                            $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                            $this->model->validate($validate);
                        }
                        $News=new \app\common\model\News();
                        $News->table("Yb_cms_db");
                        $result = $News->table("cms_article")->insert($params);
                        if ($result !== false) {
                            $this->success();
                        } else {
                            $this->error($this->model->getError());
                        }
                    } catch (\think\exception\PDOException $e) {
                        $this->error($e->getMessage());
                    } catch (\think\Exception $e)

                    {
                        $this->error($e->getMessage());
                    }
                }
                $this->error(__('Parameter %s can not be empty', ''));
            }
        }
        return $this->view->fetch();
    }

    /**
     * Selectpage搜索
     *
     * @internal
     */
    public function selectpage()
    {
        return parent::selectpage();

    }

}
