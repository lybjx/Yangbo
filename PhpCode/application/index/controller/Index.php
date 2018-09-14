<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use think\Request;
use qiniu;
require '../vendor/qiniu/autoload.php';
use Qiniu\Auth;
use think\paginator;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function bannerList(){
        $this->model=model('News');
        $result= $this->model->table("cms_flash")->alias('b')
            ->where("b.status=1")
            ->order("b.id", "desc")->select();
        return $result;
    }

    public function index()
    {
        $this->assign("bannerList",$this->bannerList());
        $this->assign("xshdList",$this->newslist("studentActivity",10));
        $this->assign("xsfcList",$this->newslist("xssfc",10));
        $this->assign("tdhdList",$this->newslist("tdhd",10));
        $this->assign("ggList",$this->newslist("gg",10));

        $this->assign("zsxxList",$this->newslist("zsbm",10));
        $this->assign("mtzxList",$this->newslist("mtzx",10));
        $this->assign("zpxxList",$this->newslist("zpxx",3));
        //$this->assign([""])
        return $this->view->fetch();
    }

    public function news()
    {
        $newslist = [];
        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.fastadmin.net?ref=news']);
    }
    public function newslist($cid,$count=4, $page= 1){
         if(!$this->request->isGet()){

         }
        $where="status=1 and ";
        $this->model=model('News');
        $result= $this->model->table("cms_article2category")->alias('a')
            ->join('yb_cms_db.fa_category c','c.id = a.categoryid','LEFT')
            ->join('yb_cms_db.cms_article b','a.articleid = b. id','LEFT')
            ->where(["b.status"=>1,"nickname"=>$cid])
            ->order("b.id", "desc")->limit(($page-1)*$count,$count)->select();

            return $result;
    }
    public function newsdetail( ){
        $sn= input("ksn");
        //echo $sn;
        $this->assign("ggList",$this->newslist("gg",10));
        $this->model=model('News');
        $result= $this->model->table("cms_article")->where(["sn" =>$sn])->find();
        $this->assign("news",$result);
            return $this->fetch("/index/detail");
    }
    public function qiniutoken(){
    //$qiniu=new \qiniu\Qiniu();
        $accessKey = 'syMHnod92WmgKAy2_IQ_F5GU8eIgNOUo88u1cn83';
        $secretKey = 'IAz20o14p1RlIt2-8TCBiLUGqzQd4Z9_LpIHlizT';
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        $bucket = 'yangbo';
// 生成上传Token
        $token = $auth->uploadToken($bucket);
        return $token;
    }
    public function infolist(){
        if(!$this->request->isGet()){

        }
        $this->assign("ggList",$this->newslist("gg",10));
        $this->assign("bannerList",$this->bannerList());
        $page=input("p",1);
        $cid=input("cid");
        $this->model=model('News');
        $cid=$this->model->table("yb_cms_db.fa_category")->where(["nickname"=>$cid])->find();
        $cid=$cid['id'];
        $count=20;
        $where="status=1 and ";

        $result= $this->model->table("cms_article")->alias('b')
            ->join('yb_cms_db.cms_article2category a','a.articleid = b. id','LEFT')
            ->join('yb_cms_db.fa_category c','c.id = a.categoryid','LEFT')
            ->where(["b.status"=>1,"a.categoryid"=>$cid])
            ->order("b.id", "desc")
            ->paginate(1);

$this->assign("list",$result);
         $page = $result->render();

        $this->assign('page', $page);
        return $this->fetch("/index/list");
    }
}
