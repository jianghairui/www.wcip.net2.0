<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/11/29
 * Time: 13:35
 */
namespace app\api\controller;

use think\Db;

class Test extends Common {

    public function index() {
        $id = input('param.id',8);
        try {
            $where = [
                ['id','=',$id]
            ];
            $info = Db::table('mp_article')->where($where)->find();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        $this->assign('content',$info['content']);
        return $this->fetch();
    }

}