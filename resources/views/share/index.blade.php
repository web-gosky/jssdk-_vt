<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>我是故事王</title>

        <!-- Sets initial viewport load and disables zooming  -->
        <meta name="viewport" content="target-densitydpi=device-dpi,width=640, user-scalable=0" id="viewport">

        <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta name="apple-touch-fullscreen" content="yes" />
        <meta name="format-detection" content="telephone=no"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
          <meta name="csrf-token" content="{{ csrf_token() }}">
   		 <meta name="base-url" content="{{ config('app.url') . '/' . $expert_code }}">
        <!-- Include the lib CSS -->
        <link href="http://img.vitabee.cn/web/open/static/lib/css/swiper.min.css" rel="stylesheet">
        <link href="http://img.vitabee.cn/web/open/static/lib/css/normalize.min.css" rel="stylesheet">
        <link href="http://img.vitabee.cn/web/open/static/lib/css/vitabee.css?v=1465915368" rel="stylesheet">
        <!--<link rel="stylesheet" href="http://img.vitabee.cn/web/open/static/lib/css/weui.min.css">
        <link rel="stylesheet" href="http://img.vitabee.cn/web/open/static/lib/css/jquery-weui.css">-->
        <!-- Include the CSS -->
        <link href="http://img.vitabee.cn/web/open/static/css/act/index.css" rel="stylesheet">
        <!-- Include the lib JS -->
        <script src="http://img.vitabee.cn/web/open/static/lib/js/jquery2.min.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/swiper.min.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/jquery-weui.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/woqu.base.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/masonry-docs.min.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/js/common.js"></script>
        <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.0/css/amazeui.min.css">
        <link rel="stylesheet" href="{{ $assets_path_res}}css/app.css" />
        <script type="text/javascript" src="{{ $assets_path_res}}js/index.js" ></script>
        <style>
            html {
                background-color: #2ea7e0;
                font-size: 1.2rem!important;
            }

            body {
                background-color: #2ea7e0;
            }

            .act-info.index {
                height: 1083px;
                background-image: url({{ $assets_path }}images/act-rule-bg.png);
                background-position-y: -15px;
            }

            .act-join-btn-img {
                background-image: url({{ $assets_path }}images/chakan1.png);
            }

            .d_play {
                position: relative;
                top: 50%;
                width: 45px;
                margin-top: -22px;
            }

            .act-show-li-img {
                text-align: center;
            }

            .d_chakan {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 40px;
            }

            .act-show-li-info {
                font-size: 0.9rem!important;
                font-family: "Helvetica Neue", Helvetica, sans-serif!important;
            }
        </style>
    </head>
    <body>
    	<a href='{{ config('app.url') . '/' . $expert_code }}+'/index'' class="d_chakan"><img src="{{ $assets_path }}images/chakan.png"></a>
    	<div class="act-banner"><img src="{{ $assets_path}}images/5-share-01-01.png" width="100%" alt=""></div>
    	<div style="width: 100%;background-color:#143667 ;">
            <div class="am-g  am-margin-top-md">
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
                                        <span> {{ $upr_detail['all_integer'] }}&nbsp;<img src="{{ $assets_path}}images/5-share-01-05.png"class="am-img-responsive"alt="5-share-01-01.png"/></span>
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
                                    <p class="am-margin-bottom-0" style="font-size: 1.1rem;">
                                        <span class="g-text-yellow">{{ $upr_detail['child_nickname'] }}</span>&nbsp;<span class="g-text-yellow">小朋友</span>&nbsp;正在参与家庭阅读公益活动，培养孩子阅读好习惯，能助公益还能赢大奖。
                                    </p>
                                </div>
                            </div>
                            <div class="g-share-like am-padding-top-sm am-padding-bottom-sm">
                                <div class="am-margin-right-sm am-margin-left-sm am-cf">
                                    <div class="am-g">
                                        <div class="am-u-sm-8 am-cf">
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
            </div>
            <div id="share-up" class="">
                <img src="{{ $assets_path }}images/share-up.png" alt="">
            </div>
            <!--  <audio id="audio" src="{{ $upr_detail['audio_url'] }}"></audio>-->
            <audio id="audio" controls  preload><source src="{{ $upr_detail['audio_url'] }}" type="audio/mpeg"></audio>

            <div class="d_share">
                <img src="{{ $assets_path }}images/share_current.png"/>
            </div>
        </div>

        <div class="hide" id="warp">
            <a href="/vitabee/read/plandetails">
                <div class="btn-joinnow hide">立即加入，贡献阅读力量</div>
            </a>
            <div class="share-layer hide"><img src="http://img.vitabee.cn/web/open/static/img/act/index/show-share.png" alt=""></div>

            <div class="act-img-show hide">
                <img src="http://img.vitabee.cn/web/open/static/img/act/index/show-banner.jpg" alt="分享banner">
                <div class="act-img-box">
                    <div class="act-img-cont">
                        <div class="act-img-cont-warp">
                            <img width="100%" src="#" alt="分享照片" id="user_share_img">
                            <div class="act-img-disc" id="user_share_text"></div>
                            <div class="act-img-info">
                                <img class="act-img-head" id="user_avatar" />
                                <div class="act-img-zan">
                                                                      我已积累阅读力量:
                                    <span id="user_share_count"></span>
                                    <img height="50%" src="http://img.vitabee.cn/web/open/static/img/act/index/zan-hand.png" alt="赞icon">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="act-img-tag">
                        <span class="act-img-tag-li">文字读后感</span>
                    </div>
                    <div class="act-img-btn" id="zan"></div>
                </div>
            </div>
            <div class="what-space hide"></div>
            <div class="act-info index">
                <div id="act-join-num" class="index">
                    <div id="join-num-cont">
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                        <div class="join-num-int"></div>
                    </div>
                </div>
                <a href="{{ config('app.url') . '/' . $expert_code }}/document/rewards">
                    <img id="btn-rule" class="index" src="http://img.vitabee.cn/web/open/static/img/act/index/btn-rule1.png" alt="">
                </a>
                <div class="act-map index">
                    <img src="http://img.vitabee.cn/web/open/static/img/act/index/map-title.jpg" alt="">

                    @if ($expert_code == 'zhejiangtsw')
                    <img src="http://img.vitabee.cn/web/open/static/img/act/index/map_zjtsw.png">
                    @else
                    <img class="act-map-img" src="http://img.vitabee.cn/web/open/static/img/act/index/map.png" alt="">
                    @endif

                    <a href="http://xw.qq.com//zj/20160513046985/?from=timeline&isappinstalled=0">
                        <img class="act-rule-img" src="http://img.vitabee.cn/web/open/static/img/act/index/act-rule-img.png" style="">
                    </a>
                    <div class="act-map-progress">
                        <div class="act-map-progress-cont">
                            <div class="act-map-progress-bar"></div>
                            <div class="act-map-progress-tip"></div>
                            <div class="act-map-progress-title"></div>
                        </div>
                    </div>
                </div>
                <div class="act-join-btn" id="joinNowBtn">
                    <a href="/vitabee/read/plandetails">
                        <div class="act-join-btn-img act-join-btn-box"></div>
                    </a>
                </div>
            </div>
            <!--<div class="act-gift">
                <img src="http://img.vitabee.cn/web/open/static/img/act/index/gift2.jpg" width="100%" alt="">
            </div>-->

            <!-- <div class="act-gift"><img src="http://img.vitabee.cn/web/open/static/img/act/index/gift2.jpg" width="100%" alt=""></div> -->
            <div class="act-show">
                <!-- <div class="act-show-part">
                    <div class="act-show-part-title"><img src="http://img.vitabee.cn/web/open/static/img/act/index/p1-title.jpg" width="100%" alt=""></div>
                    <div id="show-img" class="act-show-part-cont"></div>
                    <div class="show-more">查看更多</div>
                </div> -->
                 <div class="act-show">
                    <div class="act-show-part">
                        <div class="act-show-part-title"><img src="http://img.vitabee.cn/web/open/static/img/act/index/p3-title.jpg" width="100%" alt=""></div>
                        <a href="{{ config('app.url') . '/' . $expert_code }}/document/ranktopall">
                            <div class="act-rule-info">
                                <img src="http://img.vitabee.cn/web/open/static/img/act/index/rule.png" alt="">
                            </div>
                        </a>
                        <div class="act-rank-box">
                            <div class="act-rank" id="rankAll"></div>
                        </div>
                        <div class="act-show-part-title"><img src="{{ $assets_path }}images/p4-title.png" width="100%" alt=""></div>
                        <a href="{{ config('app.url') . '/' . $expert_code }}/document/ranktopweek">
                            <div class="act-rule-info">
                                <img src="http://img.vitabee.cn/web/open/static/img/act/index/rule.png" alt="">
                            </div>
                        </a>
                        <div class="act-rank-box">
                            <div class="act-rank" id="rankWeek"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="act-show">
                <div class="act-show-part">
                    <div class="act-show-part-title" style="margin-bottom: 25px;">
                    	<img src="{{ $assets_path }}images/p1-title.png" width="100%" alt="">
                    </div>
                    <div id="show-img" class="act-show-part-cont"></div>
                    <div class="show-more">查看更多</div>
                </div>
                <div class="act-join-btn" id="joinNowBtn">
                    <a href="{{ config('app.url') . '/' . $expert_code }}/familyread" id="more_url">
                        <div class="act-join-btn-img act-join-btn-box"></div>
                    </a>
                </div>
            </div>
        </div>
    </body>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="http://cdn.amazeui.org/amazeui/2.7.0/js/amazeui.js"></script>
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
                        $('<img src="{{ $member_info['avatar_url'] }}" class="am-circle am-img-responsive am-fl g-like-avatar" alt="5-share-01-01.png" />').prependTo(".am-u-sm-8.am-cf");
                        (".g-point-bottom").text(add);

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
    <script>
    var _url=$('meta[name="base-url"]').attr('content');
    window.ORGANIZATION = '/vitabee';
    var H, scrollNum, fallsImgsArr, $msnry;
    var previewImageArr=[];
    var FALLSEACH = 10;
    var MOBILEOBJ;
    var age = 'unknow';
    var is_join = '';
    console.log(_url + '/index/activitydetail');
    $(function(){
        // $.showLoading('拼命加载中~');
        // 判断是否已参加
        if (is_join == '1' || is_join == 1) {
            $('.act-join-btn-img').addClass('more');
            $('#more_url').attr('href', '/familyread');
        }
        // 请求活动首页接口
        $.post(_url + '/index/activitydetail', function(res){
            // 头部的数据  里程碑
            loadActivityData(res);
            $.hideLoading();
            $('html,body').css('background-color','#fff');
            // 请求排行数据
            $.post(_url + '/index/activityessences', function(res){
                ActivityDataForRank(res);
            });
        });
        // 页面加载活动数据
        var loadActivityData = function(res) {
            // 头部的数据
            var num = scrollNum = res.data.detail.integer_count;
            joinNumShow(num.toString());
            $('#warp').removeClass('hide');
            // 里程碑
            var milestone = res.data.milestone;
            var percent = (milestone['milestone_integer'] / milestone['milestone_integer_count']).toFixed(3);
            var percent2 = percent.slice(0, 4);
            $('.act-map-progress-title').html(milestone['name']);
            mapProgress(percent2);
        }
        var ActivityDataForRank = function(res){
            // 排行榜
            var dtRankAll = function(top) {
                var arr = [];
                for (var i = 0; i < top.length; i++) {
                    var obj = {
                        img: top[i]['avatar_url'],
                        name: top[i]['nickname'],
                        zan: top[i]['all_integer'],
                    }
                    arr.push(obj);
                }
                return arr;
            }
            console.info(res.data.record);
            //瀑布流图片数组
            fallsImgsArr = res.data.record;
            //瀑布流资源对象
            var fallsObj = creatFalls({
                data: dtFalls(fallsImgsArr.slice(0,previewImageArr.length+FALLSEACH)),
                id: '#show-img'
            });
            previewImageArr = fallsObj.imgArr;
            var fallsDom = fallsObj.dom;
            //如果没了就隐藏按钮
            if(fallsImgsArr.length==previewImageArr.length){
                $('.act-show-part .show-more').addClass('hide');
            }
            //初始化瀑布流
            $('#show-img').append(fallsDom).imagesLoaded(function() {
                $msnry = $('#show-img').masonry({
                    itemSelector: '.act-show-li',
                    gutter: 18
                });
            });
            creatRank({
                data: dtRankAll(res.data.top_all),
                id: '#rankAll'
            });
            creatRank({
                data: dtRankAll(res.data.top_week),
                id: '#rankWeek'
            });
        }

        H = $(window).height()||$(document.body).height();
        $('.share-layer').click(function(){
            $(this).hide(0);
        });
        //点击立即参加移除sessionStorage.package_id
        $('#joinNowBtn').click(function(){
            sessionStorage.removeItem("package_id");
        });
        //点击一起晒'查看更多'
        $('.act-show-part .show-more').click(function(){
            console.info(fallsImgsArr.length);
            console.info(previewImageArr.length);
            var oldnum = previewImageArr.length;
            var need = fallsImgsArr.length - previewImageArr.length;
            var fallsObj;
            if(need>0){
                if(need-FALLSEACH>0){
                    fallsObj = creatFalls({
                        data: dtFalls(fallsImgsArr.slice(oldnum,oldnum+FALLSEACH)),
                        id: '#show-img'
                    });
                }else{
                    fallsObj = creatFalls({
                        data: dtFalls(fallsImgsArr.slice(oldnum,oldnum+need)),
                        id: '#show-img'
                    });
                }
                previewImageArr = previewImageArr.concat(fallsObj.imgArr);
                var fallsDom = fallsObj.dom;
                $msnry.append(fallsDom).imagesLoaded(function() {
                    $msnry.masonry('appended', fallsDom);
                });
                //如果没了就隐藏按钮
                if(fallsImgsArr.length==previewImageArr.length){
                    $('.act-show-part .show-more').addClass('hide');
                }
            }
        });
        $('#show-img').on('click','.act-show-li',function(){
            var index = $(this).index();
            wx.previewImage({
                current: previewImageArr[index], // 当前显示图片的http链接
                urls: previewImageArr // 需要预览的图片http链接列表
            });
        });
        if(woqu.browser.versions.iPhone){
            setupWebViewJavascriptBridge(function(bridge) {
                //error('bridge创建成功：'+bridge);
                var btn = document.getElementById('joinNowBtn');
                btn.onclick = function(e){
                    e.preventDefault();
                    var id = age < 7 ? 16 : 17;
                    //error('id:'+ id);
                    bridge.callHandler('goToPackageGroup', {'recommend_package_id': 0,'url': 'https://www.baidu.com/','recommend_special_id': id, 'expert_id':0}, function(response) {
                        //error('发送成功'+ response);
                    });
                }
            });
        }

        if(woqu.browser.versions.android){
            if(window.vitabee){
                MOBILEOBJ = window.vitabee;
                var btn = document.getElementById('joinNowBtn');
                btn.onclick = function(e){
                    e.preventDefault();
                    var id = age < 7 ? 16 : 17;
                    MOBILEOBJ.goToPackageGroup(id);
                }
            }
        }

        //for IOS
        function setupWebViewJavascriptBridge(callback) {
            if (window.WebViewJavascriptBridge) {
                return callback(WebViewJavascriptBridge);
            }
            if (window.WVJBCallbacks) {
                return window.WVJBCallbacks.push(callback);
            }

            window.WVJBCallbacks = [callback];
            var WVJBIframe = document.createElement('iframe');
            WVJBIframe.style.display = 'none';
            WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
            document.documentElement.appendChild(WVJBIframe);
            setTimeout(function() {
                document.documentElement.removeChild(WVJBIframe)
            }, 0);
        }
    });
    // 一起晒
    var dtFalls = function(record) {
        var arr = [];
        for (var i = 0; i < record.length; i++) {
            var obj = {};
            obj.img = record[i]['photo_url'];
            obj.title = record[i]['content'];
            obj.name = record[i]['child_nickname'];
            obj.zan = record[i]['integer_count'];
            arr.push(obj);
        }
        return arr;
    }
    </script>
    <div style="display:none">
        <script src="http://s4.cnzz.com/z_stat.php?id=1258736425&web_id=1258736425" language="JavaScript"></script>
    </div>
</html>
