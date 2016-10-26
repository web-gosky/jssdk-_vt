<!doctype html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>总榜规则</title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
   	<meta name="base-url" content="{{ config('app.url') . '/' . $expert_code }}">

    <link rel="icon" type="image/png" href="{{ $assets_path }}i/favicon.png">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="{{ $assets_path }}i/app-icon72x72-2x.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="apple-touch-icon-precomposed" href="{{ $assets_path }}i/app-icon72x72-2x.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="{{ $assets_path }}i/app-icon72x72-2x.png">
    <meta name="msapplication-TileColor" content="#0e90d2">

    <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.0/css/amazeui.min.css">
    <link rel="stylesheet" href="{{$assets_path_res}}css/app.css">
    	   	<style>
    		.am-u-sm-offset-1 {
	margin-left: 0!important;
}

.am-u-sm-10 {
	width: 100%!important;
}
    	</style>
</head>

<body class="g-document-blue-bg">
    <img src="{{ $assets_path }}images/4-document-01-01.png" class="am-img-responsive full-width" alt="4-document-01-01.png"/>
    <div class="am-g am-margin-top-sm">
        <div class="am-u-sm-10 am-u-sm-offset-1 am-u-md-8 am-u-md-offset-2">
            <img src="{{ $assets_path }}images/4-document-01-02.png" class="am-img-responsive full-width" alt="4-document-01-02.png"/>
        </div>
    </div>
    <div class="am-g am-margin-top-sm am-margin-top-md">
        <div class="am-u-sm-10 am-u-sm-offset-1 am-u-md-8 am-u-md-offset-2">
            <img src="{{ $assets_path }}images/4-document-01-03.png" class="am-img-responsive full-width" alt="4-document-01-03.png"/>
        </div>
    </div>
    <div class="am-g am-margin-top-sm">
        <div class="am-u-sm-10 am-u-sm-offset-1 am-u-md-8 am-u-md-offset-2">
            <img src="{{ $assets_path }}images/4-document-01-04.png" class="am-img-responsive full-width" alt="4-document-01-04.png"/>
        </div>
    </div>
    <div class="am-g am-margin-top-sm">
        <div class="am-u-sm-10 am-u-sm-offset-1 am-u-md-8 am-u-md-offset-2">
            <img src="{{ $assets_path }}images/4-document-01-05.png" class="am-img-responsive full-width" alt="4-document-01-05.png"/>
        </div>
    </div>
    <div class="am-g am-margin-top-sm am-margin-bottom-sm">
        <div class="am-u-sm-10 am-u-sm-offset-1 am-u-md-8 am-u-md-offset-2">
            <img src="{{ $assets_path }}images/4-document-01-06.png" class="am-img-responsive full-width" alt="4-document-01-06.png"/>
        </div>
    </div>

    <!--在这里编写你的代码-->

    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="http://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
    <!--<![endif]-->
    <!--[if lte IE 8 ]>
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
    <script src="http://cdn.amazeui.org/amazeui/2.7.0/js/amazeui.ie8polyfill.min.js"></script>
    <![endif]-->
    <script src="http://cdn.amazeui.org/amazeui/2.7.0/js/amazeui.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
 		appId:'{{ $jssdk_config['appid']}}', // 必填，公众号的唯一标识
		timestamp:'{{ $jssdk_config['timestamp']}}', // 必填，生成签名的时间戳
        nonceStr:'{{ $jssdk_config['noncestr']}}', // 必填，生成签名的随机串
        signature:'{{ $jssdk_config['signature']}}', // 必填，签名，见附录1
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });

    wx.ready(function() {
    	var Url=$('meta[name="base-url"]').attr('content');
        var title = '为孩子益起读 ，用阅读力量捐建乡村小学图书馆！';
        var desc = '我们爱阅读，还能让更多孩子有书读。益起读吧！';
        var link = Url+'/index';
        var imgUrl = "http://img.vitabee.cn/web/open/static/img/act/share-img.jpg";

        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function() {

            },
            cancel: function() {

            }
        });

        //分享到朋友
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            desc: desc, // 分享描述
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function() {

            },
            cancel: function() {
                // 用户取消分享后执行的回调函数

            }
        });

        //分享到QQ
        wx.onMenuShareQQ({
            title: title, // 分享标题
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            desc: desc, // 分享描述
            success: function() {

            },
            cancel: function() {

            }
        });

        //分享到新浪微博
        wx.onMenuShareWeibo({
            title: title, // 分享标题
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            desc: desc, // 分享描述
            success: function() {

            },
            cancel: function() {

            }
        });

        //分享到QQ空间
        wx.onMenuShareQZone({
            title: title, // 分享标题
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            desc: desc, // 分享描述
            success: function() {

            },
            cancel: function() {

            }
        });
    });
    </script>
</body>

</html>
