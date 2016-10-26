<!doctype html>
<html class="no-js">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="">
		<meta name="keywords" content="">
	<meta name ="viewport" content ="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
		<title>上传阅读记录</title>
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

    	<meta name="csrf-token" content="{{ csrf_token() }}">
    	<meta name="base-url" content="{{ config('app.url') . '/' . $expert_code }}">
		<link rel="apple-touch-icon-precomposed" href="{{ $assets_path }}i/app-icon72x72-2x.png">
		<!-- Tile icon for Win8 (144x144 + tile color) -->
		<meta name="msapplication-TileImage" content="{{ $assets_path }}i/app-icon72x72-2x.png">
		<meta name="msapplication-TileColor" content="#0e90d2">
		<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.0/css/amazeui.min.css">
		<link rel="stylesheet" href="{{$assets_path_res}}css/app.css" />
		<style>

		</style>
	</head>

	<body style="background-color: #FFF;">
		<div class="d_head">
			<p style="	margin-top: 10px;">上传阅读照片或录制音频故事均可参与活动</p>
			<p>每日可传2条内容，分享邀好友助力可获更多阅读力量哦！</p>
		</div>
		<div class="d_container">
			<div class="d_fen">
				<div class="d_audio" id="d_audio">
					<img src="{{ $assets_path }}images/adds.png">
					<p>上传音频</p>
				</div>
			</div>
			<div class="d_fen">
				<div class="d_img" id="d_img">
					<img src="{{ $assets_path }}images/adds.png">
					<p>上传图片</p>
				</div>
			</div>
			<a class="d_sub" id="d_sub" style="color: #fff;" js_voice="" js_img="">上传</a>
			<a class="d_huo" style="color: #f66400;"   href="{{ config('app.url') . '/' . $expert_code }}/document/rewards">如何获得奖励?</a>
		</div>
		<div class="d_xuan">
			<img src="{{ $assets_path }}images/3-media-06.png">
		</div>
		<div class="d_history">
			@if (empty($user_package_records))
			<p style="text: center;">您曾经上传的阅读记录</p>
			@else
			<p>您曾经上传的阅读记录</p>
			@endif
			@if (!empty($user_package_records))
			<ul>
				@foreach ($user_package_records as $upr)
				<li style="text-align: center;">
					<a href="{{ config('app.url') . '/' . $expert_code }}/share?upr_id={{ $upr['upr_id'] }}">
						@if (!empty($upr['audio_url']))
						<img src="{{ $assets_path }}images/5-share-01-03.png" id="d_play1">
						@endif
						<img src="{{ $upr['photo_url'] }}" class="d_historyImg" />
					</a>
				</li>
				@endforeach
			</ul>
			@endif
		</div>
		<div class="d_zhe"></div>
		<div class="d_tan">
			<img src="{{ $assets_path }}images/guanbi.png" class="d_guanbi"/>
			<img src="{{ $assets_path }}images/xx.png" class="d_changan">
				<p class="d_miao" style="opacity:0 ;"><span>0</span>s</p>
			<div class="d_top" id="moni" >
				<img src="{{ $assets_path }}images/luyin.png">
			</div>
			<p><img src="{{ $assets_path }}images/laji.png" class="d_laji" style="display: none;"></p>
			<div class="d_submit d_active1" js_localid="" js_miao="" js_imglocal style="display: none;">确定</div>
		</div>
	</body>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	    <script type="text/javascript" src="{{ $assets_path }}js/jquery.min.js" ></script>
    <script>
    var current = 1;

function upload_sound() {
	if (isWeixinBrowser()) { //微信
		alert('Normal!!!');
		//不执行操作
	} else if (woqu.browser.versions.iPhone) { //苹果
		//冗余代码，封装后安卓不能用
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
			}, 0)
		}
		setupWebViewJavascriptBridge(function(bridge) {
			bridge.registerHandler('uploadSoundSuccess', function(data) {
				callbackOpenUploadSound(data);
			}); //注册方法给OC调用
			bridge.callHandler('openUploadSound', {
				'upload_time': 60
			}, function(response) {}); //调用OC方法
		});
	} else { //安卓
		// var expert_share_ele = document.getElementById('expert-share');
		// var expert_share_url = expert_share_ele.getAttribute('data-href');
		// window.location.href = expert_share_url;
		if (window.vitabee) {
			MOBILEOBJ = window.vitabee;
			MOBILEOBJ.openUploadSound(60);
		}
	}
}

function callbackOpenUploadSound(data) {alert(data)}
	//      alert(data);
	var audioEle = document.getElementById("audio");
	$(".d_audio img").click(function() {
			upload_sound();
			$("#audio source").attr("src");
			if (current == 1) {
				$(this).attr("src", "{{ $assets_path }}images/share_pause.png");
				audioEle.play();
			}
			if (current == 2) {
				$(this).attr("src", "{{ $assets_path }}images/5-share-01-03.png");
				audioEle.pause();
				current = 0;
			}
			current++;
			$(".d_sub ").css("background-color", "#ffc832");
			})

	$("#d_img img").click(function() {
	$("#d_img img").css("margin-top", "20px");
	$("#d_img img").css("width", "75px");
	$("#d_img img").css("height", "75px");
	$(".d_img img").attr("src", "http://vitabeedev.oss-cn-hangzhou.aliyuncs.com/package_record/20160622082634_5769db3abb3b4.jpg");
	$(".d_img p").remove();
	$(".d_sub ").css("background-color", "#ffc832");
})
document.querySelector('#d_sub').onclick = function() {
		if ($("#audio source").attr("src") != "" || $(".d_img img").attr("src") != "http://test.open.vitabee.cn/assets/images/adds.png";) {
			var _url = $('meta[name="base-url"]').attr('content');
			$.ajax({
						type: "get",
						url: _url + '/media/upload',
						async: true,
						data: {
							sound_url: $("#audio source").attr("src"),
							img_url: $(".d_img img").attr("src"),
						},
						success: function(data) {
								if (data.status == 10000) {
									location.href = _url +'/share?upr_id=' + data.data.upr_id;
				} else {
					alert(data.message);
				}
			}
		});
	}
};
//}
	    </script>
	    </html>