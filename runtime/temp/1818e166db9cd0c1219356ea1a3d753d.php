<?php /*a:4:{s:68:"/var/www/zhi.jianghairui.com/application/admin/view/index/index.html";i:1556418001;s:70:"/var/www/zhi.jianghairui.com/application/admin/view/public/header.html";i:1555594715;s:69:"/var/www/zhi.jianghairui.com/application/admin/view/public/aside.html";i:1556601776;s:70:"/var/www/zhi.jianghairui.com/application/admin/view/public/footer.html";i:1551872245;}*/ ?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <!--_footer 作为公共模版分离出去-->
    <script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
    <script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
    <script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
    <!--/_footer 作为公共模版分离出去-->
    <title>山海文化管理系统</title>
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="<?php echo url('Index/index'); ?>">纸巾机后台</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.0</span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>管理员&nbsp;&nbsp;</li>
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A"><?php echo htmlentities(app('session')->get('realname')); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onClick="member_add('个人信息','<?php echo url("Login/personal"); ?>','800','500')">个人信息</a></li>
                            <li><a href="<?php echo url('Login/logout'); ?>">退出</a></li>
                        </ul>
                    </li>
                    <!--<li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>-->
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
    <?php if(session('username')===config('superman')): ?>
        <dl id="menu-member">
            <dt><i class="Hui-iconfont">&#xe60d;</i> 设备管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('Tissue/deviceList'); ?>" data-title="设备列表" href="javascript:void(0);">设备列表</a></li>
                    <li><a data-href="<?php echo url('Tissue/orderList'); ?>" data-title="订单列表" href="javascript:void(0);">订单列表</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-weixin">
            <dt><i class="Hui-iconfont">&#xe60d;</i> 公众号<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('Menu/menuList'); ?>" data-title="菜单设置" href="javascript:void(0);">菜单设置</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('Admin/adminlist'); ?>" data-title="管理员列表" href="javascript:void(0)">管理员列表</a></li>
                    <li><a data-href="<?php echo url('Admin/grouplist'); ?>" data-title="角色管理" href="javascript:void(0)">角色管理</a></li>
                    <li><a data-href="<?php echo url('Admin/rulelist'); ?>" data-title="权限管理" href="javascript:void(0)">权限管理</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-system">
            <dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('System/syslog'); ?>" data-title="系统日志" href="javascript:void(0)">系统日志</a></li>
                </ul>
            </dd>
        </dl>

    <?php else: if(in_array(strtolower('Tissue'),$authlist)): ?>
        <dl id="member">
            <dt><i class="Hui-iconfont">&#xe60d;</i> 设备管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <?php if(in_array(strtolower('Tissue/deviceList'),$authlist)): ?>
                    <li><a data-href="<?php echo url('Tissue/deviceList'); ?>" data-title="设备列表" href="javascript:void(0);">设备列表</a></li>
                    <?php endif; if(in_array(strtolower('Tissue/orderList'),$authlist)): ?>
                    <li><a data-href="<?php echo url('Tissue/orderList'); ?>" data-title="订单列表" href="javascript:void(0);">订单列表</a></li>
                    <?php endif; ?>
                </ul>
            </dd>
        </dl>
        <?php endif; if(in_array(strtolower('Admin'),$authlist)): ?>
        <dl id="admin">
            <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <?php if(in_array(strtolower('Admin/adminlist'),$authlist)): ?>
                    <li><a data-href="<?php echo url('Admin/adminlist'); ?>" data-title="管理员列表" href="javascript:void(0)">管理员列表</a></li>
                    <?php endif; if(in_array(strtolower('Admin/grouplist'),$authlist)): ?>
                    <li><a data-href="<?php echo url('Admin/grouplist'); ?>" data-title="角色管理" href="javascript:void(0)">角色管理</a></li>
                    <?php endif; if(in_array(strtolower('Admin/rulelist'),$authlist)): ?>
                    <li><a data-href="<?php echo url('Admin/rulelist'); ?>" data-title="权限管理" href="javascript:void(0)">权限管理</a></li>
                    <?php endif; ?>
                </ul>
            </dd>
        </dl>
        <?php endif; if(in_array(strtolower('System'),$authlist)): ?>
        <dl id="system">
            <dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <?php if(in_array(strtolower('System/syslog'),$authlist)): ?>
                    <li><a data-href="<?php echo url('System/syslog'); ?>" data-title="系统日志" href="javascript:void(0);">系统日志</a></li>
                    <?php endif; ?>
                </ul>
            </dd>
        </dl>
        <?php endif; endif; ?>

    </div>
</aside>

<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <span title="我的桌面" data-href="welcome.html">我的桌面</span>
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <div class="page-container">
                <p class="f-20 text-success">欢迎使用纸巾机后台管理系统</p>
                <p>登录次数：<?php echo htmlentities(app('session')->get('login_times')); ?> </p>
                <p>上次登录IP：<?php echo htmlentities(app('session')->get('last_login_ip')); ?>  上次登录时间：<?php if((session('last_login_time'))): ?>
                    <?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric(app('session')->get('last_login_time'))? strtotime(app('session')->get('last_login_time')) : app('session')->get('last_login_time'))); endif; ?>
                </p>
                <table class="table table-border table-bordered table-bg mt-20">
                    <thead>
                    <tr>
                        <th colspan="2" scope="col">服务器信息</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th width="30%">服务器计算机名</th>
                        <td><span id="lbServerName">山海文化</span></td>
                    </tr>
                    <tr>
                        <td>服务器IP地址</td>
                        <td><?php echo htmlentities(app('request')->server('server_addr')); ?></td>
                    </tr>
                    <tr>
                        <td>服务器域名</td>
                        <td><?php echo htmlentities(app('request')->server('http_host')); ?></td>
                    </tr>
                    <tr>
                        <td>服务器端口 </td>
                        <td><?php echo htmlentities(app('request')->server('server_port')); ?></td>
                    </tr>
                    <tr>
                        <td>服务器软件 </td>
                        <td><?php echo htmlentities(app('request')->server('server_software')); ?></td>
                    </tr>
                    <tr>
                        <td>项目所在目录 </td>
                        <td><?php echo htmlentities(app('request')->server('document_root')); ?></td>
                    </tr>
                    <tr>
                        <td>服务器操作系统 </td>
                        <td>CentOS release 6.5 (Final)</td>
                    </tr>
                    <tr>
                        <td>服务器脚本超时时间 </td>
                        <td>60秒</td>
                    </tr>
                    <tr>
                        <td>服务器当前时间 </td>
                        <td id="clock"></td>
                    </tr>
                    <tr>
                        <td>CPU 核数 </td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>CPU 型号 </td>
                        <td>Intel(R) Xeon(R) Platinum 8163 CPU @ 2.50GHz</td>
                    </tr>
                    <tr>
                        <td>服务器内存 </td>
                        <td>8192M</td>
                    </tr>
                    <tr>
                        <td>当前系统用户名 </td>
                        <td><?php echo htmlentities(app('request')->server('user')); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <script>
                var int = setInterval("clock()",50);


                function clock()
                {
                    document.getElementById("clock").innerHTML=show()+'<br>'
                }

                function show(){
                    var mydate = new Date();
                    var str = "" + mydate.getFullYear() + "年";
                    str += (Array(2).join('0') + (mydate.getMonth() + 1)).slice(-2) + "月";
                    str += (Array(2).join('0') + mydate.getDate()).slice(-2) + "日 ";
                    str += (Array(2).join('0') + mydate.getHours()).slice(-2) + ":";
                    str += (Array(2).join('0') + mydate.getMinutes()).slice(-2) + ":";
                    str += (Array(2).join('0') + mydate.getSeconds()).slice(-2);
                    return str;
                }
            </script>
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前 </li>
        <li id="closeall">关闭全部 </li>
    </ul>
</div>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
    $(function(){
        /*$("#min_title_list li").contextMenu('Huiadminmenu', {
            bindings: {
                'closethis': function(t) {
                    console.log(t);
                    if(t.find("i")){
                        t.find("i").trigger("click");
                    }
                },
                'closeall': function(t) {
                    alert('Trigger was '+t.id+'\nAction was Email');
                },
            }
        });*/
    });
    /*个人信息*/
    function myselfinfo(){
        layer.open({
            type: 1,
            area: ['300px','200px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: '查看信息',
            content: '<div>管理员信息</div>'
        });
    }

    /*资讯-添加*/
    function article_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-添加*/
    function picture_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*产品-添加*/
    function product_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*用户-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }


</script>
</body>
</html>