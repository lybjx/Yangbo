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
    protected $rulelist = [];
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
        //$this->assign('newsList',$newsList);
            $total = count($newsList);
            $result = array("total" => $total, "rows" => $newsList);

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $this->model=model('News');
            $total = $this->model->table("cms_article")
                ->where($where)
                ->order("id", $order)
                ->count();

            $list = $this->model->table("cms_article")
                ->where($where)
                ->order("id", $order)
                ->limit($offset, $limit)
                ->select();

            unset($v);
            $result = array("total" => $total, "rows" => $list);

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
                $categoryids=$params['categoryids'];
                unset($params['categoryids']);
                //print_r($params);die;
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
                        $result = $News->table("cms_article")->insertGetId($params);
                        if ($result !== false) {
                            $articleid=$result;
                            $ids=explode(",",$categoryids);
                            foreach($ids as $kk=>$vv){
                                $data['categoryid']=$vv;
                                $data['articleid']=$articleid;
                                $News->table("cms_article2category")->insert($data);
                            }
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
        $this->model = model('Category');
        // 必须将结果集转换为数组
        $ruleList = collection($this->model->order('id', 'desc')->select())->toArray();
        foreach ($ruleList as $k => &$v)
        {
            $v['title'] = __($v['name']);
            if($v['pid']==0){
                $v['disabled']="true";
            }
        }
        unset($v);
        Tree::instance()->init($ruleList);
        $this->rulelist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
        foreach ($this->rulelist as $k => &$v)
        {

            $ruledata[$v['id']] = $v['title'];
        }
        $ruleList = collection($this->model->order('id', 'desc')->select())->toArray();
        $nodeList = [];
        foreach ($ruleList as $k => $v)
        {
            $selected = [];
            $state = array('selected' => false ? false : in_array($v['id'], $selected));
            $nodeList[] = array('id' => $v['id'], 'parent' => $v['pid'] ? $v['pid'] : '#', 'text' => __($v['name']), 'type' => 'menu', 'state' => $state);
        }
        Tree::instance()->init($nodeList);
        $this->assign("nodeList", $nodeList);
        $this->view->assign('ruledata', $ruledata);
        $this->view->assign("statusList", ['normal' => "Normal", 'hidden' => false]);
        // 必须将结果集转换为数组
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
    public function edit($ids=null)
    {
        if ($this->request->isAjax())
        {
            if ($this->request->isPost()) {
                $params = $this->request->post("row/a");
                $categoryids=$params['categoryids'];
                unset($params['categoryids']);
                //print_r($params);die;
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
                        $result = $News->table("cms_article")->update($params);
                        if ($result !== false) {
                            $articleid=$ids;
                            $ids=explode(",",$categoryids);
                            foreach($ids as $kk=>$vv){
                                $data['categoryid']=$vv;
                                $data['articleid']=$articleid;
                                $News->table("cms_article2category")->insert($data);
                            }
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
        $this->model = model('Category');
        // 必须将结果集转换为数组
        $ruleList = collection($this->model->order('id', 'desc')->select())->toArray();
        foreach ($ruleList as $k => &$v)
        {
            $v['title'] = __($v['name']);
            if($v['pid']==0){
                $v['disabled']="true";
            }
        }
        unset($v);
        Tree::instance()->init($ruleList);
        $this->rulelist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
        foreach ($this->rulelist as $k => &$v)
        {

            $ruledata[$v['id']] = $v['title'];
        }
        $ruleList = collection($this->model->order('id', 'desc')->select())->toArray();
        $nodeList = [];
        foreach ($ruleList as $k => $v)
        {
            $selected = [];
            $state = array('selected' => false ? false : in_array($v['id'], $selected));
            $nodeList[] = array('id' => $v['id'], 'parent' => $v['pid'] ? $v['pid'] : '#', 'text' => __($v['name']), 'type' => 'menu', 'state' => $state);
        }
        $this->model=model('News');
        $articledetail = $this->model->get(['id' => $ids]);
        $News=new \app\common\model\News();
        $cids=collection($News->table("cms_article2category")->where("articleid=".$ids)->select())->toArray();
        $selectcids="";
        foreach($cids as $kk=>$vv){
            $selectcids.=$vv['categoryid'].",";
        }
        $selectcids= substr($selectcids,0,strlen($selectcids)-1);
        //print_r($cids);die;
        Tree::instance()->init($nodeList);
        $this->assign("nodeList", $nodeList);
        $this->view->assign('ruledata', $ruledata);
        $this->assign('detail', $articledetail);
        $this->assign('selectcids',$selectcids);
        //print_r($articledetail);die;
        $this->view->assign("statusList", ['normal' => "Normal", 'hidden' => false]);
        // 必须将结果集转换为数组
        return $this->view->fetch();
    }

    public function del($ids=0){
        if ($this->request->isAjax())
        {
            try {
                        $News=new \app\common\model\News();
                        $result = $News->table("cms_article")->where("id=".$ids)->delete();
                        $re=$News->table("cms_article2category")->where("articleid=".$ids)->delete();

                            $this->error();

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
