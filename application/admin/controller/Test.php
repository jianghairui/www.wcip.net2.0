<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/8/24
 * Time: 13:30
 */
namespace app\admin\controller;

use think\Controller;

class Test extends Controller {

    public function index() {
        echo serialize([]);
//        halt($_SERVER);
    }


}

