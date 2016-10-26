<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
<meta name ="viewport" content ="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>我是故事王</title>
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
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
    			<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="base-url" content="{{ config('app.url') . '/' . $expert_code }}">
            <link href="http://img.vitabee.cn/web/open/static/css/act/index.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.0/css/amazeui.min.css">
    <link rel="stylesheet" href="{{ $assets_path_res}}css/app.css">
    <style>
        .act-join-btn-img {
            background-image: url({{ $assets_path }}images/chakan.png);
        }
        .act-join-btn-box{
            height: 43px;
        }
    </style>

</head>


<body class="g-share-blue-bg">
    <img src="{{ $assets_path }}images/5-share-01-01.png" class="am-img-responsive full-width" alt="5-share-01-01.png" />
    <!-- 分享图片区 -->
    <div class="am-g am-margin-top-sm am-margin-top-md">
        <div class="am-u-sm-10 am-u-sm-offset-1 am-u-md-8 am-u-md-offset-2 g-share-warp">
            <!-- 黑条 -->
            <div class="g-share-blackline">
                <span class="am-badge am-round">&nbsp;</span>
            </div>
            <!-- 白块-内容区 -->
            <div class="g-share-content-warp" id="g-share-content-warp">
                <div class="g-share-content">
                    <div class="g-share-img am-padding-top-sm">
                        <div class="am-margin-right-sm am-margin-left-sm">
                            <img src="{{ $upr_detail['photo_url'] }}" class="am-img-responsive full-width" alt="" />
                        </div>
                        <div class="g-user-count-point">
                            <div class="g-point-top">
                                <span>我已积累阅读力量</span>
                            </div>
                            <div class="g-point-bottom">
                           <span>{{ $upr_detail['all_integer'] }}&nbsp;<img src="{{ $assets_path }}images/5-share-01-05.png" class="am-img-responsive" alt="5-share-01-01.png" /></span>
                            </div>
                        </div>
                        <div class="g-user-sound">
                            <div class="g-user-avatar">
                                <p>
                                    <img src="{{ $upr_detail['child_avatar_url'] }}" class="am-img-responsive" alt="" />
                                </p>
                            </div>
                            <div class="g-sound-btn">
                                @if (!empty($upr_detail['audio_url']))
                                <img src="{{ $assets_path }}images/5-share-01-03.png" class="am-img-responsive" alt="" />
        						@endif
                            </div>
                            <div class="g-user-talk">
                                <img src="{{ $assets_path }}images/audio_back.png" class="am-img-responsive" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="g-share-text am-padding-top-sm">
                        <div class="am-margin-right-sm am-margin-left-sm">
                            <p class="am-margin-bottom-0">
                                <span class="g-text-yellow">{{ $upr_detail['child_nickname'] }}</span>&nbsp;<span class="g-text-yellow">小朋友</span>&nbsp;正在参与家庭阅读公益活动，培养孩子阅读好习惯，能助公益还能赢大奖。
                            </p>
                        </div>
                    </div>
                    <div class="g-share-like am-padding-top-sm am-padding-bottom-sm">
                        <div class="am-margin-right-sm am-margin-left-sm am-cf">
                            <div class="am-g">
                                <div class="am-u-sm-8 am-cf"  >
                                    @foreach ($like_users as $like_user)
                                    <img src="{{ $like_user['avatar_url'] }}" class="am-circle am-img-responsive am-fl g-like-avatar" alt="5-share-01-01.png" />
                                    @endforeach
                                </div>
                                <div class="am-u-sm-4" id="d_zan">
                                    <img src="{{ $assets_path }}images/5-share-01-04.png" class="am-img-responsive g-like-btn" alt="5-share-01-01.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="act-join-btn" id="joinNowBtn">
            <a href="{{ config('app.url') . '/' . $expert_code }}/familyread" id="more_url">
                <div class="act-join-btn-img act-join-btn-box"></div>
            </a>
        </div>
    </div>
   <!--  <audio id="audio" src="{{ $upr_detail['audio_url'] }}"></audio>-->
    <audio id="audio" controls  preload>
        <source src="{{ $upr_detail['audio_url'] }}" type="audio/mpeg">
    </audio>
    <div class="d_share">
        <img src="{{ $assets_path }}images/share_current.png"/>
    </div>
    <!--在这里编写你的代码-->
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="//cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
    <!--<![endif]-->
    <!--[if lte IE 8 ]>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
    <script src="http://cdn.amazeui.org/amazeui/2.7.0/js/amazeui.ie8polyfill.min.js"></script>
    <![endif]-->
    <script src="http://cdn.amazeui.org/amazeui/2.7.0/js/amazeui.js"></script>
    	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function error(msg) {
        $("body").append('<div class="d_error" style="display:block;"><div class="d_error2"><p>' + msg + '</p></div>');
        setTimeout(function() {
            $(".d_error").remove();
        }, 1500)
    }
    </script>
    <script>
	var current=1;
	var _time;
    var _time1;
    var audioEle = document.getElementById("audio");

	$(".g-sound-btn img").click(function(){
        if (current==1) {
            $(this).attr("src","{{ $assets_path }}images/share_pause.png");
            audioEle.play();
        }
        if (current==2) {
            $(this).attr("src","{{ $assets_path }}images/5-share-01-03.png");
            audioEle.pause();
            current=0;
        }
        current++;
	});
	var _time=setTimeout(function(){
        $(".d_share").slideDown();
	},1000);

	var _time1=setTimeout(function(){
        $(".d_share").slideUp();
	},3000);

	$("#d_zan").click(function(){
        clearTimeout(_time1);
        var _url = $('meta[name="base-url"]').attr('content');
		$.ajax({
			type:"get",
			url: _url +'/share/like',
			async:true,
			data:{
				upr_id:{{ $upr_detail['upr_id'] }}
			},
			success:function(data){
				if(data.status==10000){
                    // $(".d_share").hide();
                    // switch(data.data.result_code){
                    // case 1:
                    // }
					if (data.data.result_code==1) {
						var currentNumble=parseInt($(".g-point-bottom").text());
						var add=parseInt(data.data.integer)+currentNumble;

                        $(".g-point-bottom").text(add);
                        $('<img src="{{ $member_info['avatar_url'] }}" class="am-circle am-img-responsive am-fl g-like-avatar" alt="5-share-01-01.png" />').prependTo(".am-u-sm-8.am-cf");
                        $(".d_share").slideDown();
                        $(".d_share img").attr("src","{{ $assets_path }}images/share_success.png");
					}
					if (data.data.result_code==0){
                        error("您已经点过赞了");
                        $(".d_share").slideDown();
                        $(".d_share img").attr("src","{{ $assets_path }}images/share_error.png");
					}
                    if (data.data.result_code==-1){
                        error("您点得太快了");
                    }
                    if (data.data.result_code==-2){
                        error("每天只能点一次赞哦");
                    }
                    if (data.data.result_code==-3){
                        error("当前活动已过期");
                    }
                    if (data.data.result_code==-4){
                        error("不可以给自己点赞哦");
                    }
				}
				else{
					error("点赞失败,请稍后重试");
				}
			}
		});
	});
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端error出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId:'{{ $jssdk_config['appid'] }}', // 必填，公众号的唯一标识
        timestamp:'{{ $jssdk_config['timestamp'] }}', // 必填，生成签名的时间戳
        nonceStr:'{{ $jssdk_config['noncestr'] }}', // 必填，生成签名的随机串
        signature:'{{ $jssdk_config['signature'] }}', // 必填，签名，见附录1
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'stopVoice',
            'uploadVoice',
            'onVoicePlayEnd',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'translateVoice',
        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    wx.ready(function() {
        var timer=parseInt( new Date().getMinutes());
        if (timer%2==0) {
        	var title='我正在参与“为孩子益起读”公益活动，20次助力能让一个乡村儿童有本书读！';
        	var desc='用阅读助力公益,举手之劳,快来助力吧！';
        } else{
      		var title='我家宝贝用阅读积累了{{ $upr_detail["all_integer"] }}阅读力量，相当于让{{ $upr_detail["all_integer"]/20 }}人次乡村儿童有本书读!';
        	var desc='一起阅读力量大,快来参加吧！';
        }
    	// var title = '为孩子益起读 ，用阅读力量捐建乡村小学图书馆！';
    	// var desc = '我们爱阅读，还能让更多孩子有书读。益起读吧！';
    	var link = "{{ config('app.url') . '/' . $expert_code }}/share?upr_id={{ $upr_detail['upr_id'] }}";
    	var imgUrl ="{{ $upr_detail['photo_url'] }}";
    	wx.onMenuShareTimeline({
    		title: title, // 分享标题
    		link: link, // 分享链接
    		imgUrl: imgUrl, // 分享图标
    		success: function() {},
    		cancel: function() {}
    	});
    	//分享到朋友
    	wx.onMenuShareAppMessage({
    		title: title, // 分享标题
    		link: link, // 分享链接
    		imgUrl: imgUrl, // 分享图标
    		desc: desc, // 分享描述
    		type: '', // 分享类型,music、video或link，不填默认为link
    		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    		success: function() {},
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
    		success: function() {},
    		cancel: function() {}
    	});
    	//分享到新浪微博
    	wx.onMenuShareWeibo({
    		title: title, // 分享标题
    		link: link, // 分享链接
    		imgUrl: imgUrl, // 分享图标
    		desc: desc, // 分享描述
    		success: function() {},
    		cancel: function() {}
    	});
    	//分享到QQ空间
    	wx.onMenuShareQZone({
    		title: title, // 分享标题
    		link: link, // 分享链接
    		imgUrl: imgUrl, // 分享图标
    		desc: desc, // 分享描述
    		success: function() {},
    		cancel: function() {}
    	});
    });
    </script>
</body>
</html>
