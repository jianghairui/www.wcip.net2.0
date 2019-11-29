<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/11/29
 * Time: 15:16
 */
namespace app\admin\controller;

use think\Db;
class User extends Base {

    public function signList() {
        $param['datemin'] = input('param.datemin');
        $param['datemax'] = input('param.datemax');
        $param['search'] = input('param.search');

        $page['query'] = http_build_query(input('param.'));

        $curr_page = input('param.page',1);
        $perpage = input('param.perpage',10);

        $where = [];
        if($param['datemin']) {
            $where[] = ['create_time','>=',date('Y-m-d 00:00:00',strtotime($param['datemin']))];
        }

        if($param['datemax']) {
            $where[] = ['create_time','<=',date('Y-m-d 23:59:59',strtotime($param['datemax']))];
        }

        if($param['search']) {
            $where[] = ['name|tel|desc','like',"%{$param['search']}%"];
        }
        $order = ['id'=>'DESC'];
        try {
            $count = Db::table('mp_contact')->where($where)->count();
            $page['count'] = $count;
            $page['curr'] = $curr_page;
            $page['totalPage'] = ceil($count/$perpage);
            $list = Db::table('mp_contact')->where($where)
                ->order($order)
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('param',$param);
        return $this->fetch();
    }

    public function contact() {
        $id = input('post.id');
        try {
            $where = [
                ['id','=',$id]
            ];
            Db::table('mp_contact')->where($where)->update(['contact'=>1]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }




}