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



    public function partnerList()
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
        $count = Db::table('mp_partner')->where($where)->count();

        $page['count'] = $count;
        $page['curr'] = $curr_page;
        $page['totalPage'] = ceil($count/$perpage);
        try {
            $list = Db::table('mp_partner')
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

    public function partnerAdd() {
        return $this->fetch();
    }

    public function partnerAddPost() {
        $val['type'] = input('post.type',1);
        $val['title'] = input('post.title');
        $val['desc'] = input('post.desc');
        $val['status'] = input('post.status');
        checkInput($val);
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
            Db::table('mp_partner')->insert($val);
        }catch (\Exception $e) {
            if(isset($val['pic'])) {
                @unlink($val['pic']);
            }
            return ajax($e->getMessage(),-1);
        }
        return ajax([]);

    }

    public function partnerDetail() {
        $partner_id = input('param.id');
        try {
            $exist = Db::table('mp_partner')->where('id','=',$partner_id)->find();
            if(!$exist) {
                die('非法操作');
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        $this->assign('info',$exist);
        return $this->fetch();
    }

    public function partnerMod() {
        $val['type'] = input('post.type',1);
        $val['title'] = input('post.title');
        $val['desc'] = input('post.desc');
        $val['status'] = input('post.status');
        $val['id'] = input('post.id');
        checkInput($val);
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
            $exist = Db::table('mp_partner')->where($where)->find();
            if(!$exist) {
                return ajax('非法参数',-1);
            }
            Db::table('mp_partner')->where($where)->update($val);
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

    public function partnerDel() {
        $val['id'] = input('post.id');
        checkInput($val);
        try {
            $exist = Db::table('mp_partner')->where('id','=',$val['id'])->find();
            if(!$exist) {
                return ajax('非法操作',-1);
            }
            Db::table('mp_partner')->where('id','=',$val['id'])->delete();
        }catch (\Exception $e) {
            return ajax($e->getMessage(),-1);
        }
        @unlink($exist['pic']);
        return ajax([],1);
    }

    public function partnerHide()
    {
        $val['id'] = input('post.id');
        checkInput($val);
        try {
            $exist = Db::table('mp_partner')->where('id','=',$val['id'])->find();
            if (!$exist) {
                return ajax('非法操作', -1);
            }
            Db::table('mp_partner')->where('id','=',$val['id'])->update(['status' => 0]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }

    public function partnerShow() {
        $val['id'] = input('post.id');
        checkInput($val);
        try {
            $exist = Db::table('mp_partner')->where('id','=',$val['id'])->find();
            if(!$exist) {
                return ajax('非法操作',-1);
            }
            Db::table('mp_partner')->where('id','=',$val['id'])->update(['status'=>1]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }

    public function sortPartner() {
        $val['id'] = input('post.id');
        $val['sort'] = input('post.sort');
        checkInput($val);
        try {
            Db::table('mp_partner')->update($val);
        }catch (\Exception $e) {
            return ajax($e->getMessage(),-1);
        }
        return ajax($val);
    }

}