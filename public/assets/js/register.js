$(function() {
	var _iphone = $(".iphone input").val();
	var _text = $(".text input").val();
	var reg = /^1[3|4|5|7|8]\d{9}$/;

	function error(msg) {
		$("body").append('<div class="d_error" style="display:block;"><div class="d_error2"><p>' + msg + '</p></div>');
		setTimeout(function() {
			$(".d_error").remove();
		}, 1500)
	}
//	$(".iphone input").blur(function() {
//		var _iphone = $(".iphone input").val();
//		if (!(reg.test(_iphone))) {
//			error('手机号码格式有误')
//		}
//		if (_iphone == "") {
//			error("请填写手机号")
//		};
//	})
	$(".d_hold").click(function() {
		var _url= $('meta[name="base-url"]').attr('content');
		var _iphone = $(".iphone input").val();
		if (_iphone=="") {
				error("请填写手机号")
		} else{
				$.ajax({
			type: "get",
			url: _url + '/wechatauth/sendcode',
			data:{
				 cellphone:_iphone,
			},
			success: function(data) {
				if (data.status == 10000) {
					$(".d_hold").html(data.message);
					//					$(".d_next").attr("js_text",data.data.timestamp);
				} else {
					error(data.message);
				}
			}
		});
		}
		
	
	})
	$(".d_next").click(function() {
	var _url= $('meta[name="base-url"]').attr('content');
		var _iphone = $(".iphone input").val();
		var _text = $(".text input").val();
		if (!(reg.test(_iphone))) {
			error('手机号码格式有误');
			return false
		}
		if (_iphone == "") {
			error("请填写手机号");
			return false
		};
		if (_text == "") {
			error("请填写验证码");
			return false
		};
				$.ajax({
			type: "get",
			url: _url + '/wechatauth/checkcode',
			data:{
				 cellphone:_iphone,
				  code :_text,
			},
			success: function(data) {
				if (data.status == 10000) {
				location.href = _url + '/wechatauth/addchild';
					//					$(".d_next").attr("js_text",data.data.timestamp);
				} else {
					error(data.message);
				}
			}
		});
	

	})

})