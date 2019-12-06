<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/12/6
 * Time: 16:45
 */
namespace app\admin\controller;

class Api extends Base {

    public function index() {
        echo 'INDEX:' . $this->cmd;
    }

    public function test() {
        echo 'TEST:' . $this->cmd;
    }


}