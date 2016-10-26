function getValFromUrl(str) {
    var reg = new RegExp("(^|&)" + str + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]);
    return null;
}

function creatRank() {
    var argument = arguments[0];
    var datas = argument.data;
    var len = datas.length;
    var $container = $(argument.id);

    for (var i = 0; i < len; i++) {
        var imgsrc = common.setHeadImg(datas[i].img);
        var dom = '<div class="act-rank-li">' +
            '<div class="act-rank-li-head">' +
            '<div class="act-rank-li-head-img" style="background-image:url(' + imgsrc + ')"></div>' +
            '</div>' +
            '<div class="act-rank-li-info">' +
            '<div class="act-rank-li-info-cont">' +
            '<div class="act-rank-li-name">' + datas[i].name + '</div>' +
            '<div class="act-rank-li-zan">' + datas[i].zan + '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $container.append($(dom));
    }
}

function creatFalls() {

    var datas = arguments[0].data;
    //console.info(datas)
    var len = datas.length;

    var imgArr = [];
    var dom = '';

    for (var i = 0; i < len; i++) {
        dom += '<div class="act-show-li">' +
            '<div class="act-show-li-cont">' +
            '<div class="act-show-li-img">' +
               '<img  class="d_play"  src="">' +
            '<div class="act-show-li-img-cont">' +
            '<img src="' + datas[i].img + '">' +
            '</div>' +
            '</div>' +
            '<div class="act-show-li-info">' +
            '<div class="act-show-li-info-title">' +
            datas[i].title +
            '</div>' +
            '<div class="act-show-li-info-name">' +
            datas[i].name +
            '</div>' +
            '</div>' +
            '<div class="act-show-li-zan">精选</div>' +
            '</div>' +
            '</div>';
        imgArr.push(datas[i].img);
    }

    var obj = {imgArr:imgArr,dom:$(dom)};

    return obj;
}

function mapProgress(percent) {
    var MAXTIP = -186;
    var MAXBAR = 192;
    $('.act-map-progress-tip').css('transform', 'translateY(' + (percent * MAXTIP) + 'px)');
    $('.act-map-progress-bar').css('height', (percent * MAXBAR) + 'px');
    $('.act-map-progress-tip').text('已完成' + Math.round(percent * 100) + '%');
}

function joinNumShow(number) {
    $('.join-num-int').addClass('numAni');
    setTimeout(function() {
        var fanHeight = 108;
        var TIME = 100;
        // console.info(number);
        var arr = number.split("");
        var len = arr.length;
        if (len != 8) {
            var l = 8 - len;
            for (var j = 0; j < l; j++) {
                arr.unshift(0);
            };
        }
        console.info(arr);


        function stopnum(i) {
            setTimeout(function() {
                $('.join-num-int:eq(' + i + ')').css({
                    'background-position': 'center ' + (-fanHeight * 9 + arr[i] * fanHeight - 3) + 'px'
                }).removeClass('numAni');
            }, (9 - i) * TIME);
        }

        for (var i = 9; i >= 0; i--) {
            stopnum(i);
        }
    }, 500);
}

//立即加入按钮
var BtnJoinNow = {
    show: function() {
        $('.btn-joinnow').removeClass('hide');
    },
    hide: function() {
        $('.btn-joinnow').addClass('hide');
    }
}

//share-layer
var ShareLayer = {
    show: function() {
        $('.share-layer').removeClass('slideUpHide');
    },
    hide: function() {
        $('.share-layer').addClass('slideUpHide');
    }
}
//share-layer
var ShareLayer2 = {
    show: function() {
        $('.share-layer2').removeClass('hide');
    },
    hide: function() {
        $('.share-layer2').addClass('hide');
    }
}

var ShareLayer3 = {
    show: function() {
        $('.share-layer3').removeClass('hide');
    },
    hide: function() {
        $('.share-layer3').addClass('hide');
    }
}
