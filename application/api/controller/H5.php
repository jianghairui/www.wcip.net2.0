<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/11/25
 * Time: 9:43
 */
namespace app\api\controller;

use think\Db;
class H5 extends Common {

    public function slideList() {
        try {
            $where = [
                ['type','=',2]
            ];
            $order = ['sort'=>'ASC'];
            $list = Db::table('mp_slideshow')->where($where)->order($order)->select();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($list);
    }

    public function articleSlide() {
        $curr_page = input('post.page',1);
        $perpage = input('post.perpage',10);
        $curr_page = $curr_page ? $curr_page:1;
        $perpage = $perpage ? $perpage:10;
        $where = [];


        try {
            $count = Db::table('mp_article')->where($where)->count();
            $page['count'] = $count;
            $page['curr'] = $curr_page;
            $page['totalPage'] = ceil($count/$perpage);
            $list = Db::table('mp_article')
                ->where($where)
                ->order(['sort'=>'ASC','create_time'=>'DESC'])
                ->field('id,title')
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $ret['count'] = $count;
        $ret['list'] = $list;
        return ajax($ret);
    }

    public function productList() {
        $curr_page = input('post.page',1);
        $perpage = input('post.perpage',10);

        $curr_page = $curr_page ? $curr_page:1;
        $perpage = $perpage ? $perpage:10;
        $where = [];
        try {
            $whereTags = [
                ['type','=',1],
                ['del','=',0]
            ];
            $tag_list = Db::table('mp_tags')->where($whereTags)->select();

            $count = Db::table('mp_product')->where($where)->count();

            $page['count'] = $count;
            $page['curr'] = $curr_page;
            $page['totalPage'] = ceil($count/$perpage);
            $list = Db::table('mp_product')
                ->where($where)
                ->order(['sort'=>'ASC','create_time'=>'DESC'])
                ->field('id,title,pic,tags')
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
            $tags = [];
            foreach ($tag_list as $t) {
                $tags[$t['id']] = $t['tag_name'];
            }
            foreach ($list as &$v) {
                $tags_arr = explode(',',$v['tags']);
                $tag_names = [];
                foreach ($tags_arr as $tid) {
                    if(isset($tags[$tid])) {
                        $tag_names[] = $tags[$tid];
                    }
                }
                $v['tag_names'] = $tag_names;
            }
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $ret['count'] = $count;
        $ret['list'] = $list;
        return ajax($ret);
    }

    public function productDetail() {
        $val['id'] = input('post.id');
        checkPost($val);
        $where = [
            ['id','=',$val['id']]
        ];
        try {
            $exist = Db::table('mp_product')->where($where)->field('id,title,content,pic,tags,create_time')->find();
            if(!$exist) {
                return ajax('invalid id',-4);
            }
            $whereTags = [
                ['type','=',1],
                ['del','=',0]
            ];
            $tag_list = Db::table('mp_tags')->where($whereTags)->select();
            $tags = [];
            foreach ($tag_list as $t) {
                $tags[$t['id']] = $t['tag_name'];
            }

            $tags_arr = explode(',',$exist['tags']);
            $tag_names = [];
            foreach ($tags_arr as $tid) {
                if(isset($tags[$tid])) {
                    $tag_names[] = $tags[$tid];
                }
            }
            $exist['tag_names'] = $tag_names;
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($exist);
    }

    public function caseList() {
        $curr_page = input('post.page',1);
        $perpage = input('post.perpage',10);
        $post['type'] = input('post.type');
        checkPost($post);
        $curr_page = $curr_page ? $curr_page:1;
        $perpage = $perpage ? $perpage:10;
        $where = [
            ['status','=',1]
        ];
        if($post['type']) {
            $where[] = ['type','=',$post['type']];
        }
        try {
            $count = Db::table('mp_case')->where($where)->count();

            $page['count'] = $count;
            $page['curr'] = $curr_page;
            $page['totalPage'] = ceil($count/$perpage);
            $list = Db::table('mp_case')
                ->where($where)
                ->order(['sort'=>'ASC','id'=>'DESC'])
                ->field('id,title,pic')
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $ret['count'] = $count;
        $ret['list'] = $list;
        return ajax($ret);
    }

    public function caseDetail() {
        $val['id'] = input('post.id');
        checkPost($val);
        try {
            $where = [
                ['id','=',$val['id']]
            ];
            $info = Db::table('mp_case')->where($where)->find();
            if(!$info) {
                return ajax('invalid id',-4);
            }
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }

    public function articleList() {
        $curr_page = input('post.page',1);
        $perpage = input('post.perpage',10);
        $id = input('post.id',0);
        $type = input('post.type',1);
        $curr_page = $curr_page ? $curr_page:1;
        $perpage = $perpage ? $perpage:10;
        $where = [
            ['status','=',1]
        ];
        try {
            if($id) {
                $where[] = ['recommend','=',1];
                $where[] = ['id','<>',$id];
            }
            if($type) {
                $where[] = ['type','=',$type];
            }
            $count = Db::table('mp_article')->where($where)->count();
            $page['count'] = $count;
            $page['curr'] = $curr_page;
            $page['totalPage'] = ceil($count/$perpage);
            $list = Db::table('mp_article')
                ->where($where)
                ->order(['sort'=>'ASC','create_time'=>'DESC'])
                ->field('id,title,pic,views,create_time')
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $ret['count'] = $count;
        $ret['list'] = $list;
        return ajax($ret);
    }

    public function partnerList() {
        $curr_page = input('post.page',1);
        $perpage = input('post.perpage',10);
        $post['type'] = input('post.type');
        checkPost($post);
        $curr_page = $curr_page ? $curr_page:1;
        $perpage = $perpage ? $perpage:10;
        $where = [];
        if($post['type']) {
            $where[] = ['type','=',$post['type']];
        }
        try {
            $count = Db::table('mp_partner')->where($where)->count();

            $page['count'] = $count;
            $page['curr'] = $curr_page;
            $page['totalPage'] = ceil($count/$perpage);
            $list = Db::table('mp_partner')
                ->where($where)
                ->order(['sort'=>'ASC','id'=>'DESC'])
                ->field('id,title,pic')
                ->limit(($curr_page - 1)*$perpage,$perpage)->select();
        }catch (\Exception $e) {
            die('SQL错误: ' . $e->getMessage());
        }
        $ret['count'] = $count;
        $ret['list'] = $list;
        return ajax($ret);
    }

    public function aboutUs() {
        try {
            $where = [
                ['id','=',1]
            ];
            $info = Db::table('mp_home')->where($where)
                ->field('logo,name,address,linkman,tel,qq,email,desc,intro,years,partners,fans,users,contacts,plan,honor')
                ->find();
            if(!$info) {
                return ajax('未找到信息',-1);
            }
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }

    public function friendLinks() {
        try {
            $list = Db::table('mp_links')->field('title,logo,url')->select();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($list);
    }

    public function aboutShandong() {
        try {
            $where = [
                ['id','=',2]
            ];
            $info = Db::table('mp_home')->where($where)
                ->field('desc,intro,role0,role1,role2,role3,video_url,role0_icon,role1_icon,role2_icon,role3_icon,qrcode3')
                ->find();
            if(!$info) {
                return ajax('未找到信息',-1);
            }
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }

    public function serviceList() {
        try {
            $list = Db::table('mp_service')->select();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($list);
    }

    public function serviceDetail() {
        $val['id'] = input('post.id');
        checkPost($val);
        try {
            $where = [
                ['id','=',$val['id']]
            ];
            $info = Db::table('mp_service')->where($where)->field('title,title_en,content,pic')->find();
            if(!$info) {
                return ajax('invalid id',-4);
            }
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }



    public function articleDetail() {
        $val['id'] = input('post.id');
        checkPost($val);
        try {
            $where = [
                ['id','=',$val['id']]
            ];
            $info = Db::table('mp_article')->where($where)->field('title,desc,content,pic,create_time,views,author')->find();
            if(!$info) {
                return ajax('invalid id',-4);
            }
            Db::table('mp_article')->where($where)->setInc('views',1);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }

    public function contactUs() {
        $val['name'] = input('post.name');
        $val['tel'] = input('post.tel');
        $val['desc'] = input('post.desc');
        checkPost($val);
        try {
            if(!is_tel($val['tel'])) {
                return ajax('无效的手机号',6);
            }
            Db::table('mp_contact')->insert($val);
            Db::table('mp_home')->where('id','=',1)->setInc('contacts',1);
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax();
    }

    public function teamList() {
        try {
            $where = [
                ['id','<>',1]
            ];
            $list = Db::table('mp_team')->where($where)->select();
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($list);
    }

    public function teamDetail() {
        $val['id'] = input('post.id');
        checkPost($val);
        try {
            $where = [
                ['id','=',$val['id']]
            ];
            $info = Db::table('mp_team')->where($where)->find();
            if(!$info) {
                return ajax('invalid id',-4);
            }
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }

    public function aboutBwgsd() {
        try {
            $where = [
                ['id','=',3]
            ];
            $info = Db::table('mp_home')->where($where)
                ->field('intro')
                ->find();
            if(!$info) {
                return ajax('未找到信息',-1);
            }
        } catch (\Exception $e) {
            return ajax($e->getMessage(), -1);
        }
        return ajax($info);
    }







}