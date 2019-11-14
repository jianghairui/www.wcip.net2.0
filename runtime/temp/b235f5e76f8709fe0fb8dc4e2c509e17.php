<?php /*a:1:{s:62:"/var/www/zhi.jianghairui.com/application/api/view/pay/pay.html";i:1555291971;}*/ ?>
<!Doctype HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>支付中</title>
    <script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">

        function onBridgeReady(){
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest', {
                    appId:"<?php echo htmlentities($prepay['appId']); ?>",
                    timeStamp:"<?php echo htmlentities($prepay['timeStamp']); ?>",
                    nonceStr:"<?php echo htmlentities($prepay['nonceStr']); ?>",
                    package:"<?php echo htmlentities($prepay['package']); ?>",
                    signType:"MD5",
                    paySign:"<?php echo htmlentities($prepay['paySign']); ?>"
                },
                function(res){
                    if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                        $.ajax({
                            url:"<?php echo url('Pay/getGift'); ?>",
                            type:'post',
                            dataType:'json',
                            data:{device_num:"<?php echo htmlentities($gift['device_num']); ?>",num:"<?php echo htmlentities($gift['num']); ?>"},
                            success:function(data) {
                                if(data.code == 1) {
                                    alert('出纸成功');
                                    window.location.href = 'http://www.bwgsd.com/wap/';
                                    return;
                                }else {
                                    alert(data.data);
                                }
                                WeixinJSBridge.call('closeWindow');
                                document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
                            },
                            error:function(data) {
                                alert('系统异常!')
                                WeixinJSBridge.call('closeWindow');
                                document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
                            }
                        })
                    }else{
                        WeixinJSBridge.call('closeWindow');
                        document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
                    }

                }
            );
        }
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        }else{
            onBridgeReady();
        }
    </script>
</head>
<body>
</body>
</html>