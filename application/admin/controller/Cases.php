<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/11/14
 * Time: 14:57
 */
namespace app\admin\controller;

use think\Db;
class Cases extends Base {

    public function caseList()
    {
        $param['search'] = input('param.search');
        $param['type'] = input('param.type');
        $page['query'] = http_build_query(input('param.'));

        $curr_page = input('param.page',1);
        $perpage = input('param.perpage',10);
        $where = [];
        if($param['search']) {
            $where[] = ['title','like',"%{$param['search']}%"];
        }
        if($param['type']) {
            $where[] = ['type','=',$param['type']];
        }
        $count = Db::table('mp_case')->where($where)->count();

        $page['count'] = $count;
        $page['curr'] = $curr_page;
        $page['totalPage'] = ceil($count/$perpage);
        try {
            $list = Db::table('mp_case')
                ->where($where)
                ->order(['sort'=>'ASC','create_time'=>'DESC'])
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('param',$param);
        return $this->fetch();
    }

    public function caseAdd() {
        return $this->fetch();
    }

    public function caseAddPost() {
        $val['title'] = input('post.title');
        $val['desc'] = input('post.desc');
        $val['type'] = input('post.type',1);
        checkInput($val);
        $val['create_time'] = date('Y-m-d H:i:s');
        $val['admin_id'] = session('admin_id');
        if(isset($_FILES['file'])) {
            $info = upload('file',$this->upload_base_path);
            if($info['error'] === 0) {
                $val['pic'] = $info['data'];
            }else {
                return ajax($info['msg'],-1);
            }
        }else {
            return ajax('请上传封面图',-1);
        }
        try {
            Db::table('mp_case')->insert($val);
        }catch (\Exception $e) {
            if(isset($val['pic'])) {
                @unlink($val['pic']);
            }
            return ajax($e->getMessage(),-1);
        }
        return ajax([]);

    }

    public function caseDetail() {
        $case_id = input('param.id');
        try {
            $exist = Db::table('mp_case')->where('id','=',$case_id)->find();
            if(!$exist) {
                die('非法操作');
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        $this->assign('info',$exist);
        return $this->fetch();
    }

    public function caseMod() {
        $val['title'] = input('post.title');
        $val['desc'] = input('post.desc');
        $val['type'] = input('post.type',1);
        $val['id'] = input('post.id');
        checkInput($val);
        $val['admin_id'] = session('admin_id');
        if(isset($_FILES['file'])) {
            $info = upload('file',$this->upload_base_path);
            if($info['error'] === 0) {
                $val['pic'] = $info['data'];
            }else {
                return ajax($info['msg'],-1);
            }
        }
        $where = [
            ['id','=',$val['id']]
        ];
        try {
            $exist = Db::table('mp_case')->where($where)->find();
            if(!$exist) {
                return ajax('非法参数',-1);
            }
            Db::table('mp_case')->where($where)->update($val);
        }catch (\Exception $e) {
            if(isset($val['pic'])) {
                @unlink($val['pic']);
            }
            return ajax($e->getMessage(),-1);
        }
        if(isset($val['pic'])) {
            @unlink($exist['pic']);
        }
        return ajax([]);
    }

    public function caseDel() {
        $val['id'] = input('post.id');
        checkInput($val);
        try {
            $exist = Db::table('mp_case')->where('id','=',$val['id'])->find();
            if(!$exist) {
                return ajax('非法操作',-1);
            }
            Db::table('mp_case')->where('id','=',$val['id'])->delete();
        }catch (\Exception $e) {
            return ajax($e->getMessage(),-1);
        }
        @unlink($exist['pic']);
        return ajax([],1);
    }

    public function caseHide()
    {
        $val['id'] = input('post.id');
        checkInput($val);
        try {
            $exist = Db::table('mp_case')->where('id','=',$val['id'])->find();
            if (!$exist) {
                return ajax('非法操作', -1);
            }
            Db::table('mp_case')->where('id','=',$val['id'])->update(['status' => 0]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }

    public function caseShow() {
        $val['id'] = input('post.id');
        checkInput($val);
        try {
            $exist = Db::table('mp_case')->where('id','=',$val['id'])->find();
            if(!$exist) {
                return ajax('非法操作',-1);
            }
            Db::table('mp_case')->where('id','=',$val['id'])->update(['status'=>1]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }

    public function sortcase() {
        $val['id'] = input('post.id');
        $val['sort'] = input('post.sort');
        checkInput($val);
        try {
            Db::table('mp_case')->update($val);
        }catch (\Exception $e) {
            return ajax($e->getMessage(),-1);
        }
        return ajax($val);
    }



}