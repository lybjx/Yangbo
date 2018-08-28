<?php

namespace app\common\model;

use think\Model;

/**
 * 分类模型
 */
class News Extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [

    ];
    protected function initialize()
    {
        parent::initialize();
        $this->table('cms_article');//两种方法都试过
        $this->table = 'cms_article';
    }
    protected static function init()
    {
        self::afterInsert(function ($row) {
            $row->save(['weigh' => $row['id']]);
        });
    }
function getnewList($status=1){
    $newsList =News::get(['status' => '1'])->select();
    return $newsList;
}
    function getvideoList($status=1){
        $newsList =$this->table("cms_video")->get(['status' => '1'])->select();
        return $newsList;
    }





}
