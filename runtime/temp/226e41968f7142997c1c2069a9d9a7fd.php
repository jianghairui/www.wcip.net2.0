<?php /*a:3:{s:75:"/var/www/zhi.jianghairui.com/application/admin/view/tissue/device_list.html";i:1571302771;s:63:"/var/www/zhi.jianghairui.com/application/admin/view/layout.html";i:1555501083;s:70:"/var/www/zhi.jianghairui.com/application/admin/view/public/footer.html";i:1551872245;}*/ ?>
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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 设备管理 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <section id="formAjax">
        <div class="text-c">
            <button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>
            日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{ $dp.$D(\'datemax\')||\'%y-%M-%d\' }' })" id="datemin" value="<?php echo htmlentities(app('request')->get('datemin')); ?>" class="input-text Wdate" style="width:120px;" readonly>
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{ $dp.$D(\'datemin\') }' })" id="datemax" value="<?php echo htmlentities(app('request')->get('datemax')); ?>" class="input-text Wdate" style="width:120px;" readonly>
            <input type="text" name="search" value="<?php echo htmlentities(app('request')->get('search')); ?>" id="search" placeholder="设备号或设备名" style="width:250px" class="input-text">
            <button name="" id="search-btn" class="btn btn-success" type="button"><i class="Hui-iconfont">&#xe665;</i> 查找设备</button>
            <button name="" class="btn btn-info" type="button" id="toExcel"><i class="Hui-iconfont">&#xe66b;</i> 导出Excel</button>
        </div>
    </section>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="r">共有数据：<strong><?php echo htmlentities($page['count']); ?></strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr class="text-c">
            <th width="25">#</th>
            <th>设备名</th>
            <th width="80">设备号</th>
            <th width="120">销售额</th>
            <th width="80">单价</th>
            <th width="80">余量</th>
            <th width="130">操作</th>
        </tr>
        </thead>
        <tbody>
        <form id="multi-check">
            <?php foreach($list as $li): ?>
            <tr class="text-c userinfo">
                <td><?php echo htmlentities($li['id']); ?></td>
                <td><?php echo htmlentities($li['name']); ?></td>
                <td><?php echo htmlentities($li['device_num']); ?></td>
                <td><?php echo htmlentities($li['total_price']); ?></td>
                <td><?php echo htmlentities($li['unit_price']); ?></td>
                <td><?php echo htmlentities($li['stock']); ?></td>
                <td>
                    <span>
                        <a title="编辑" href="javascript:;" class="ml-5" style="text-decoration:none" onclick="add_info('编辑设备','<?php echo url("Tissue/deviceDetail",array("id"=>$li["id"])); ?>')">
                    <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </form>

        <tr>
            <td colspan="9" id="page" class="text-r"></td>
        </tr>
        </tbody>
    </table>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

    var url = '<?php echo url("Tissue/deviceList"); ?>' + '?<?php echo $page["query"];?>',totalPage = '<?php echo htmlentities($page['totalPage']); ?>';
    var curr = '<?php echo htmlentities($page['curr']); ?>';
    if(totalPage > 1) {
        laypage({
            cont: 'page', //容器。值支持id名、原生dom对象，jquery对象。
            pages: totalPage, //通过后台拿到的总页数
            skip: false, //是否开启跳页
            skin: '#5a98de',
            curr: curr || 1, //当前页
            jump: function(obj, first){ //触发分页后的回调
                // console.log(obj)
                if(!first) {
                    window.location.href = url+'&page=' + obj.curr;
                }
            }
        });
    }

    $("#search-btn").click(function () {
        var datemin = $("#formAjax").find("#datemin").val();
        var datemax = $("#formAjax").find("#datemax").val();
        var search = $("#formAjax").find("#search").val();
        var str = '';
        if(datemin.length != '') {
            str += '&datemin=' + datemin
        }
        if(datemax.length != '') {
            str += '&datemax=' + datemax
        }
        if(search.length != 0) {
            str += '&search=' + search;
        }
        window.location.href = '<?php echo url("Tissue/deviceList"); ?>' + '?' + str;
    });

    $("#toExcel").click(function () {
        var datemin = $("#formAjax").find("#datemin").val();
        var datemax = $("#formAjax").find("#datemax").val();
        var search = $("#formAjax").find("#search").val();
        var str = '';
        if(datemin.length != '') {
            str += '&datemin=' + datemin
        }
        if(datemax.length != '') {
            str += '&datemax=' + datemax
        }
        if(search.length != 0) {
            str += '&search=' + search;
        }
        window.location.href = '<?php echo url("Excel/deviceToExcel"); ?>' + '?' + str;
    });
    var isclick = true;

    /*添加分类*/
    function add_info(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }


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
