<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>家庭阅读益成长计划</title>

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
        <link rel="stylesheet" href="http://img.vitabee.cn/web/open/static/lib/css/weui.min.css">
        <link rel="stylesheet" href="http://img.vitabee.cn/web/open/static/lib/css/jquery-weui.css">

        <!-- Include the CSS -->
        <link href="http://img.vitabee.cn/web/open/static/css/act/index.css" rel="stylesheet">
	
        <!-- Include the lib JS -->
        <script src="http://img.vitabee.cn/web/open/static/lib/js/jquery2.min.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/swiper.min.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/jquery-weui.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/woqu.base.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/lib/js/masonry-docs.min.js"></script>
        <script src="http://img.vitabee.cn/web/open/static/js/common.js"></script>
   
        		<link rel="stylesheet" href="{{$assets_path_res}}css/app.css" />
        		<script type="text/javascript" src="{{ $assets_path_res }}js/index.js" ></script>
        <style>
            html{
                background-color:#2ea7e0;
            }
            body{
                background-color:#2ea7e0;
            }
.act-info.index {
    height: 1083px;
	background-image: url({{ $assets_path }}images/act-rule-bg.png);
	background-position-y: -15px;
}

.act-join-btn-img {
    background-image: url({{ $assets_path }}images/btn-act-join.png);
}
.act-join-btn-img.more{

}
.d_play{
	position: relative;
	top: 50%;
	width: 45px;
	margin-top: -22px;
}.act-show-li-img {
  
    text-align: center;
}
        </style>
    </head>
    <body>
        <div id="warp" class="hide">
            <!--<a href="/vitabee/read/plandetails">
                <div class="btn-joinnow hide">立即加入，贡献阅读力量</div>
            </a>-->
            <div class="share-layer hide"><img src="http://img.vitabee.cn/web/open/static/img/act/index/show-share.png" alt=""></div>
            <div class="act-banner"><img src="http://img.vitabee.cn/web/open/static/img/act/index/banner.jpg" width="100%" alt=""></div>
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
                <a href="javascript:">
                    <img id="btn-rule" class="index" src="http://img.vitabee.cn/web/open/static/img/act/index/btn-rule1.png" alt="">
                </a>
                <div class="act-map index">
                    <img src="http://img.vitabee.cn/web/open/static/img/act/index/map-title.jpg" alt="">
                                        <img class="act-map-img" src="http://img.vitabee.cn/web/open/static/img/act/index/map.png" alt="">

                    <a href="javascript:">
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
                <!--<div class="act-join-btn" id="joinNowBtn">
                    <a href="/vitabee/read/plandetails">
                        <div class="act-join-btn-img act-join-btn-box"></div>
                    </a>
                </div>-->
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
                    <a href="javascript:">
                        <div class="act-rule-info">
                            <img src="{{ $assets_path }}images/rule.png" alt="">
                        </div>
                    </a>
                    <div class="act-rank-box">
                        <div class="act-rank" id="rankAll"></div>
                    </div>
                    <div class="act-show-part-title"><img src="{{ $assets_path }}images/p4-title.png" width="100%" alt=""></div>
                    <a href="javascript:">
                        <div class="act-rule-info">
                            <img src="{{ $assets_path }}images/rule.png" alt="">
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
                    <div id="show-img" class="act-show-part-cont">
             
                    </div>
                    <div class="show-more">查看更多</div>
                </div>
            <div class="act-join-btn" id="joinNowBtn">
                <a href="{{ $join_url }}" id="more_url">
                    <div class="act-join-btn-img act-join-btn-box">活动已结束</div>
                </a>
            </div>
        </div>
    </body>
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
	var Url = $('meta[name="base-url"]').attr('content');
	var title = '为孩子益起读 ，用阅读力量捐建乡村小学图书馆！';
	var desc = '我们爱阅读，还能让更多孩子有书读。益起读吧！';
	var link = Url + '/index';
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
//          $.showLoading('拼命加载中~');
            // 判断是否已参加
  
            // 请求活动首页接口
            $.post(_url + '/index/activitydetail', function(res){
                // 头部的数据  里程碑
                          if (res.data.detail.is_join == '1' ||res.data.detail.is_join == 1) {
                $('.act-join-btn-img').addClass('more');

             
            }
                
                
                
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
            })
            //点击立即参加移除sessionStorage.package_id
            $('#joinNowBtn').click(function(){
                sessionStorage.removeItem("package_id");
            })
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
            })
            $('#show-img').on('click','.act-show-li',function(){
                var index = $(this).index();
                wx.previewImage({
                    current: previewImageArr[index], // 当前显示图片的http链接
                    urls: previewImageArr // 需要预览的图片http链接列表
                });
            })
            if(woqu.browser.versions.iPhone){
                setupWebViewJavascriptBridge(function(bridge) {
                    //alert('bridge创建成功：'+bridge);
                    var btn = document.getElementById('joinNowBtn');
                    btn.onclick = function(e){
                        e.preventDefault();
                        var id = age < 7 ? 16 : 17;
                        //alert('id:'+ id);
                        bridge.callHandler('goToPackageGroup', {'recommend_package_id': 0,'url': 'https://www.baidu.com/','recommend_special_id': id, 'expert_id':0}, function(response) {
                            //alert('发送成功'+ response);
                        })
                    }
                })
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
                if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
                if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
                window.WVJBCallbacks = [callback];
                var WVJBIframe = document.createElement('iframe');
                WVJBIframe.style.display = 'none';
                WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
                document.documentElement.appendChild(WVJBIframe);
                setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0);
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
    <div style="display:none"><script src="http://s4.cnzz.com/z_stat.php?id=1258736425&web_id=1258736425" language="JavaScript"></script></div>
</html>
