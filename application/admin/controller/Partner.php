<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/8/24
 * Time: 17:26
 */
namespace app\admin\controller;
use think\Db;

class Partner extends Base {


    public function linksList() {
        $param['search'] = input('param.search');
        $page['query'] = http_build_query(input('param.'));
        $curr_page = input('param.page',1);
        $perpage = input('param.perpage',10);
        $where = [];
        if($param['search']) {
            $where[] = ['title','like',"%{$param['search']}%"];
        }
        try {
            $count = Db::table('mp_links')->where($where)->count();
            $list = Db::table('mp_links')
                ->where($where)
                ->order(['id'=>'DESC'])
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }

        $page['count'] = $count;
        $page['curr'] = $curr_page;
        $page['totalPage'] = ceil($count/$perpage);
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('param',$param);
        return $this->fetch();
    }

    public function linksAdd() {
        if(request()->isPost()) {
            $val['title'] = input('post.title');
            $val['url'] = input('post.url');
            checkInput($val);
            try {
                Db::table('mp_links')->insert($val);
            }catch (\Exception $e) {
                return ajax($e->getMessage(),-1);
            }
            return ajax([]);
        }
        return $this->fetch();
    }

    public function linksDetail() {
        $val['id'] = input('param.id');
        try {
            $where = [
                ['id','=',$val['id']]
            ];
            $info = Db::table('mp_links')->where($where)->find();
            if(!$info) {
                die('非法参数');
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function linksMod() {
        if(request()->isPost()) {
            $val['title'] = input('post.title');
            $val['url'] = input('post.url');
            $val['id'] = input('post.id');
            checkInput($val);
            try {
                Db::table('mp_links')->update($val);
            }catch (\Exception $e) {
                return ajax($e->getMessage(),-1);
            }
            return ajax([]);
        }
    }

    public function linksDel() {
        if(request()->isPost()) {
            $val['id'] = input('post.id');
            checkInput($val);
            try {
                Db::table('mp_links')->delete($val);
            }catch (\Exception $e) {
                return ajax($e->getMessage(),-1);
            }
            return ajax([]);
        }
    }


}