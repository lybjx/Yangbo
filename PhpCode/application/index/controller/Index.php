<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use think\Request;
use qiniu;
require '../vendor/qiniu/autoload.php';
use Qiniu\Auth;

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
         if(!$this->request->isGet()){
echo 1;
         }
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
}
