<?php /*a:3:{s:70:"/var/www/zhi.jianghairui.com/application/admin/view/admin/ruleadd.html";i:1551872245;s:63:"/var/www/zhi.jianghairui.com/application/admin/view/layout.html";i:1555501083;s:70:"/var/www/zhi.jianghairui.com/application/admin/view/public/footer.html";i:1551872245;}*/ ?>
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
    <title></title>
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>节点名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php if($pname != '顶级节点'): ?><?php echo htmlentities($pname); ?>/<?php endif; ?>" placeholder="设置节点名称" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>节点描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="输入节点描述" id="title" name="title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>父节点：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="hidden" class="input-text" value="<?php echo htmlentities($pid); ?>" placeholder="" id="tel" name="pid" readonly>
                <input type="text" class="input-text" value="<?php echo htmlentities($pname); ?>" id="pname" readonly>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">

    $(function(){
        var isclick = true
        $("#form-admin-add").validate({
            rules:{
                name:{
                    required:true,
                    maxlength:80
                },
                title:{
                    required:true,
                    maxlength:30
                },
                pid:{
                    required:true,
                    equalTo: "#password"
                },
            },
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                if(isclick) {
                    isclick = false
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "<?php echo url('Admin/ruleadd_post'); ?>" ,
                        success: function(data){
                            console.log(data)
                            if(data.code == 1) {
                                layer.msg('添加成功!',{icon:1,time:1000},function(){
                                    window.parent.location.reload();
                                });
                            }else {
                                layer.msg(data.data,{icon:2,time:1000});
                                isclick = true
                            }
                        },
                        error: function(msg){
                            layer.msg('接口请求失败!',{icon:2,time:1000});
                            isclick = true
                        }
                    });

                }

            }
        });
    });
</script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
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


</script>
</body>
</html>
