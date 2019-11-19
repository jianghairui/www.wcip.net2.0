<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/11/19
 * Time: 9:22
 */
namespace app\admin\controller;

use think\Db;
class Product extends Base {

    public function productList() {
        $param['search'] = input('param.search');
        $page['query'] = http_build_query(input('param.'));

        $curr_page = input('param.page',1);
        $perpage = input('param.perpage',10);
        $where = [];
        if($param['search']) {
            $where[] = ['title','like',"%{$param['search']}%"];
        }

        $count = Db::table('mp_product')->where($where)->count();

        $page['count'] = $count;
        $page['curr'] = $curr_page;
        $page['totalPage'] = ceil($count/$perpage);
        try {
            $whereTags = [
                ['type','=',1],
                ['del','=',0]
            ];
            $tag_list = Db::table('mp_tags')->where($whereTags)->select();

            $list = Db::table('mp_product')
                ->where($where)
                ->order(['sort'=>'ASC','create_time'=>'DESC'])
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
            $tags = [];
            foreach ($tag_list as $v) {
                $tags[$v['id']] = $v['tag_name'];
            }
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $this->assign('list',$list);
        $this->assign('tags',$tags);
        $this->assign('page',$page);
        $this->assign('param',$param);
        return $this->fetch();
    }

    public function productAdd() {
        try {
            $whereTags = [
                ['type','=',1],
                ['del','=',0]
            ];
            $tag_list = Db::table('mp_tags')->where($whereTags)->select();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        $this->assign('tag_list',$tag_list);
        return $this->fetch();
    }

    public function productAddPost() {
        $val['title'] = input('post.title');
        $val['desc'] = input('post.desc');
        checkInput($val);
        $val['content'] = input('post.content');
        $val['tags'] = input('post.tags',[]);
        $val['status'] = input('post.status');
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
            $val['tags'] = implode(',',$val['tags']);
            Db::table('mp_product')->insert($val);
        }catch (\Exception $e) {
            if(isset($val['pic'])) {
                @unlink($val['pic']);
            }
            return ajax($e->getMessage(),-1);
        }
        return ajax([]);

    }

    public function productDetail() {
        $product_id = input('param.id');
        try {
            $exist = Db::table('mp_product')->where('id','=',$product_id)->find();
            if(!$exist) {
                die('非法操作');
            }
            $tags = explode(',',$exist['tags']);
            $whereTags = [
                ['type','=',1],
                ['del','=',0]
            ];
            $tag_list = Db::table('mp_tags')->where($whereTags)->select();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        $this->assign('tag_list',$tag_list);
        $this->assign('tags',$tags);
        $this->assign('info',$exist);
        return $this->fetch();
    }


    //修改资讯提交
    public function productMod() {
        $val['title'] = input('post.title');
        $val['desc'] = input('post.desc');
        $val['id'] = input('post.id');
        checkInput($val);
        $val['content'] = input('post.content');
        $val['status'] = input('post.status');
        $val['tags'] = input('post.tags',[]);
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
            $exist = Db::table('mp_product')->where($where)->find();
            if(!$exist) {
                return ajax('非法参数',-1);
            }
            $val['tags'] = implode(',',$val['tags']);
            Db::table('mp_product')->where($where)->update($val);
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
    //删除资讯
    public function productDel() {
        $val['id'] = input('post.id');
        checkInput($val);
        $where = [
            ['id','=',$val['id']]
        ];
        try {
            $exist = Db::table('mp_product')->where($where)->find();
            if(!$exist) {
                return ajax('非法操作',-1);
            }
            Db::table('mp_product')->where($where)->delete();
        }catch (\Exception $e) {
            return ajax($e->getMessage(),-1);
        }
        @unlink($exist['pic']);
        return ajax([],1);
    }
    //停用新闻
    public function productHide()
    {
        $val['id'] = input('post.id');
        checkInput($val);
        $where = [
            ['id','=',$val['id']]
        ];
        try {
            $exist = Db::table('mp_product')->where($where)->find();
            if (!$exist) {
                return ajax('非法操作', -1);
            }
            Db::table('mp_product')->where($where)->update(['status' => 0]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }
    //启用新闻
    public function productShow() {
        $val['id'] = input('post.id');
        checkInput($val);
        $where = [
            ['id','=',$val['id']]
        ];
        try {
            $exist = Db::table('mp_product')->where($where)->find();
            if(!$exist) {
                return ajax('非法操作',-1);
            }
            Db::table('mp_product')->where($where)->update(['status'=>1]);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }
    //文章排序
    public function sortProduct() {
        $val['id'] = input('post.id');
        $val['sort'] = input('post.sort');
        checkInput($val);
        try {
            Db::table('mp_product')->update($val);
        }catch (\Exception $e) {
            return ajax($e->getMessage(),-1);
        }
        return ajax($val);
    }





}