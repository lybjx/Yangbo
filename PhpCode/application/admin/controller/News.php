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
