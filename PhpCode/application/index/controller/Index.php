<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        return $this->view->fetch();
    }

    public function news()
    {
        $newslist = [];
        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.fastadmin.net?ref=news']);
    }
    public function newslist($cid,$count=4, $page= 1){
        $where="status=1 and ";
        $this->model=model('News');
        $result= $this->model->table("cms_article2category")->alias('a')
            ->join('cms_article b','a.pid = b. id','LEFT')
            ->where("b.status=1")
            ->order("b.id", "desc")->limit(($page-1)*$count,$count)->select();
            return $result;
    }
    public function newsdetail( ){
        $sn= input("ksn");
        //echo $sn;
        $this->model=model('News');
        $result= $this->model->table("cms_article")->where(["sn" =>$sn])->find();
            return $result;
    }
}
