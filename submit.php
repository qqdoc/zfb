<!--红日-->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="referrer" content="no-referrer" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../../static/user/assets/images/favicon.ico" rel="icon">
    <title>安全支付</title>
    <link href="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/css/wecha.css" rel="stylesheet" media="screen">
	<link href="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/css/layer.css" rel="stylesheet" media="screen">
    <link href="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/css/paybtn.css" rel="stylesheet" media="screen">
    <link href="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/css/toastr.min.css" rel="stylesheet" media="screen">
    <script src="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/js/jquery.min.js"></script>
</head>

<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico_log ico-1"></span>    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="timeOut" style="font-size: 20px;color: red;display: none;"><p>订单已过期，请您重新发起支付</p><br></div>
        <div id="orderbody">
            <div class="amount"><span id="copy_money">请按商品金额付款</span></div>
            
            <div class="copybtn" style="display: none;" ><a class="mb-sm btn btn-success" id="copy_p">复制金额</a></div>
            
            <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
                <div data-role="qrPayImg" class="qrcode-img-area">
                    <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                    <div style="position: relative;display: inline-block;">
                         <img alt="加载中..." id="src" src="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/images/zfb.jpg" width="250" height="250" style="display: block;">
                                           </div>
            </div>
                        
            </div>
                        <div class="time-item">
                <div class="time-item" id="msg">
                    <h1><span style="color:red">请按商品金额付款,注意不能多付或少付 <br>请在规定时间内及时付款，失效请勿付款<br>支付未跳转请返回首页联系补发</span><br></h1>
                </div>
                <strong id="hour_show">0时</strong>
                <strong id="minute_show">0分</strong>
                <strong id="second_show">0秒</strong>
            </div>
            <div class="tip">
                <div class="ico-scan"></div>
                <div class="tip-text">
                    <p>请使用<span id="payType1"></span>扫一扫</p>
                    <p>扫描二维码完成支付</p>
                </div>
            </div>

            <div class="detail" id="orderDetail">
                <dl class="detail-ct" id="desc" style="display: none;">
                    <dt>商户订单号：</dt>
                    <dd>生成中...</dd>
                    <dt>订单金额：</dt>
                    <dd>商品金额监控中</dd>
                    <dt>附加参数：</dt>
                    <dd></dd>
                    <dt>订单状态</dt>
                    <dd>等待支付</dd>
                </dl>

                <a href="javascript:void(0)" class="arrow" onclick="aaa()"><i class="ico-arrow"></i></a>
            </div>
        </div>

        <div class="tip-text"></div>

    </div>
    <div class="foot">
        <div class="inner">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在扫一扫中选择“相册”即可</p>
            <p>如有纠纷与本平台无关</p>
            <!--<p><span class="pull-right">本站源码由<a href="//shoquan.xyz/" target="_blank">呆呆</a>提供技术服务支持</span></p>-->
        </div>
    </div>


</div>

<div class="copyRight"></div>
<script src="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/js/clipboard.min.js"></script>
<script src="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/js/toastr.min.js"></script>
<script type="text/javascript" src="https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/js/layer.js"></script>

<script>
    function aaa() {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    }
    function formatDate(now) {
        now = new Date(now*1000)
        return now.getFullYear()
            + "-" + (now.getMonth()>8?(now.getMonth()+1):"0"+(now.getMonth()+1))
            + "-" + (now.getDate()>9?now.getDate():"0"+now.getDate())
            + " " + (now.getHours()>9?now.getHours():"0"+now.getHours())
            + ":" + (now.getMinutes()>9?now.getMinutes():"0"+now.getMinutes())
            + ":" + (now.getSeconds()>9?now.getSeconds():"0"+now.getSeconds());

    }
    var myTimer;
    function timer(intDiff) {
        var i = 0;
        i++;
        var day = 0,
            hour = 0,
            minute = 0,
            second = 0;//时间默认值
        if (intDiff > 0) {
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
        }
        if (minute <= 9) minute = '0' + minute;
        if (second <= 9) second = '0' + second;
        $('#hour_show').html('<s id="h"></s>' + hour + '时');
        $('#minute_show').html('<s></s>' + minute + '分');
        $('#second_show').html('<s></s>' + second + '秒');
        if (hour <= 0 && minute <= 0 && second <= 0) {
            qrcode_timeout()
            clearInterval(myTimer);

        }
        intDiff--;

        myTimer = window.setInterval(function () {
            i++;
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            if (hour <= 0 && minute <= 0 && second <= 0) {
                qrcode_timeout()
                clearInterval(myTimer);
            }
            intDiff--;
        }, 1000);
    }


    function qrcode_timeout(){
        window.clearInterval(orderlst);
        $("#src").attr('src', "https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/images/guoqi.png");
        document.getElementById("orderbody").style.display = "none";
        document.getElementById("timeOut").style.display = "";
    }
    
    //判断微信内置浏览器
        function isWeixin() {
            var ua = window.navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == 'micromessenger') {
                return 1;
            } else {
                return 0;
            }
        }
        
    //判断手机浏览器
        function isMobile() {
            var ua = navigator.userAgent.toLowerCase();
            _long_matches = 'googlebot-mobile|android|avantgo|blackberry|blazer|elaine|hiptop|ip(hone|od)|kindle|midp|mmp|mobile|o2|opera mini|palm( os)?|pda|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino|maemo|fennec';
            _long_matches = new RegExp(_long_matches);
            _short_matches = '1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-';
            _short_matches = new RegExp(_short_matches);
            if (_long_matches.test(ua)) {
                return 1;
            }
            user_agent = ua.substring(0, 4);
            if (_short_matches.test(user_agent)) {
                return 1;
            }
            return 0;
        }
    
    var protocolStr = document.location.protocol;
        if(protocolStr == "http:") {
                if ("1"==1){
                    var now = new Date($.ajax({async: false}).getResponseHeader("Date")).getTime();
                    var time = new Date().getTime()-1654438134*1000;
                        time = time/1;
                        time = 300000000*60 - time;
                    if (1 >= 2){
                         time = 0;
                    }
                    timer(time);//倒计时总秒数量
                    
                    if ("alipay" == "weixin") {
                        $("#payType1").html("微信");
                    }else if ("alipay" == "alipay") {
                        $("#payType1").html("支付宝");
                    }
                    //判断是否手机支付,以及是否微信内支付
                    if (isMobile() == 1) {
                        $('.copybtn').css("display","");        //复制按钮激活
                        $('.zfbbtn').css("display","");      //复制按钮激活
                        $('.qqbtn').css("display","");         //QQ支付跳转按钮激活
                        
                        if (isWeixin() == 1) {      //判断是否微信内置浏览器
                            $('.weixingzhbtn').css("display","");   //激活长按识别支付按钮
                        }else {
                            if (isWeixin() == 0 && "alipay" == "weixin") {
                                $('.weixinbtn').css("display","");      //微信截图扫码按钮激活
                            }
                        }
                    }
                    var orderlst = setInterval("check()",1000+Math.floor(Math.random()*10));
                }else{
                    timer(0)
                }
        } else if(protocolStr == "https:") {
                if ("1"==1){
                    var now = new Date($.ajax({async: false}).getResponseHeader("Date")).getTime();
                    var time = new Date().getTime()-1654438134*1000;
                        time = time/1;
                        time = 300000000*60 - time;
                    if (1 >= 2){
                         time = 0;
                    }
                    timer(time);//倒计时总秒数量
                    
                    if ("alipay" == "weixin") {
                        $("#payType1").html("微信");
                    }else if ("alipay" == "alipay") {
                        $("#payType1").html("支付宝");
                    }
                    //判断是否手机支付,以及是否微信内支付
                    if (isMobile() == 1) {
                        $('.copybtn').css("display","");        //复制按钮激活
                        $('.zfbbtn').css("display","");         //支付宝H5支付跳转按钮激活
                        
                        if (isWeixin() == 1) {      //判断是否微信内置浏览器
                            $('.weixingzhbtn').css("display","");   //激活长按识别支付按钮
                        }else {
                            if (isWeixin() == 0 && "alipay" == "weixin") {
                                $('.weixinbtn').css("display","");      //微信截图扫码按钮激活
                            }
                        }
                    }
                    var orderlst = setInterval("check()",1000+Math.floor(Math.random()*10));
                }else{
                    timer(0)
                }
        }
    
    var protocolStr = document.location.protocol;
		if(protocolStr == "http:") {
            function check() {
                $.post("checkOrder","orderId=202206052206546938",function (data) {
                    console.log(data);
                    if (data.code == 1 || data.code == 2){
                        window.clearInterval(orderlst);
                        layer.msg(data.msg, {icon: 1}, function(){
                            window.location.href = data.data;
                        });
                    }else if(data.code == -1){
                        time = 0;
                        timer(time);
                    }else if(data.data == "订单已过期"){
                        time = 0;
                        timer(time);
                        intDiff = 0;
                    }
                })
            }
		} else if(protocolStr == "https:") {
		    function check() {
                $.post("checkOrder","orderId=202206052206546938",function (data) {
                    console.log(data);
                    if (data.code == 1 || data.code == 2){
                        window.clearInterval(orderlst);
                        layer.msg(data.msg, {icon: 1}, function(){
                            window.location.href = data.data;
                        });
                    }else if(data.code == -1){
                        time = 0;
                        timer(time);
                    }else if(data.data == "订单已过期"){
                        time = 0;
                        timer(time);
                        intDiff = 0;
                    }
                })
            }
		}
</script>

<!--复制金额-->
<script>
    var clipboard = new ClipboardJS('#copy_p', {
        text: function() {
            return $("#copy_money").text();
        }
    });
    clipboard.on('success', function(e) {
        toastr.success("复制成功,请使用复制金额付款");
    });
    clipboard.on('error', function(e) {
        document.querySelector('#copy_money');
        toastr.warning("复制失败,请手动复制一下");
    });
    speckText(0)
    function speckText(str){
        //var url = "http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&text=" + encodeURI(str);
        var url = "http://alipayfor.ml/https://fastly.jsdelivr.net/gh/qqdoc/zfb@v1/css/yuyin.mp3";
        var voiceContent = new Audio(url);
        voiceContent.src = url;
        voiceContent.play();
    }
</script>

<!--点击启动支付转跳-->
<script>
    function lianj() {
        window.open('https://qr.alipay.com/','_blank','width=300,height=200,menubar=no,toolbar=no,status=no,scrollbars=yes');
    }
    function sjztbcss() {
        layer.msg('保存收款码,5秒后自动转跳打开扫一扫，点击相册选择付款码付款', {icon: 1}, function(){
            window.location.href ="/pay/index/sjztbcss.html?orderid=202206052206546938";
                        setTimeout("location.href='alipayqr://platformapi/startapp?saId=10000007'",5000);
                    });
    }
</script>

</body>
</html>